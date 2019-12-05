<?php

namespace App;

use Storage;
use Carbon\Carbon;
use App\Helpers\Helpers;
use Webpatser\Uuid\Uuid;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Constraint;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class File extends PortalBaseModel
{
    use SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | SETUP
    |--------------------------------------------------------------------------
    */

    protected $with = ['extension'];

    /**
     *  Setup model event hooks.
     */
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */

    /** @noinspection PhpMissingParentCallCommonInspection */
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    /**
     * Add mass-assignment to model.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'file_extension_id',
        'path',
        'size',
        'name',
        'public_name',
        'original_file_id',
        'drive',
        'download_count',
        'user_created_id',
        'user_created_ip',
        'user_updated_id',
        'user_updated_ip',
    ];

    /**
     * Generate a url for download the given file.
     *
     * @return UrlGenerator|string
     */
    public function downloadUrl()
    {
        return url('/download_file/'.$this->uuid);
    }

    /**
     * This will return the full path plus filename/extension.
     *
     * @return string
     */
    public function getFullPath()
    {
        $this->path ? $path = $this->path.'/' : $path = '';

        return $path.$this->getFileName();
    }

    /**
     * This will return the full filename with extension.
     *
     * @return string
     */
    public function getFileName()
    {
        return $this->name.'.'.$this->extension->name;
    }

    /**
     * Return the file's native storage url.
     *
     * @return string
     */
    public function fileUrl()
    {
        return Storage::url($this->getFullPath());
    }

    /*
    |--------------------------------------------------------------------------
    | ATTRIBUTES
    |--------------------------------------------------------------------------
    */

    /**
     * Set created_at to Carbon Object.
     *
     * @param $value
     *
     * @return mixed
     */
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->toFormattedDateString();
    }

    /**
     * Set updated_at to Carbon Object.
     *
     * @param $value
     *
     * @return mixed
     */
    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->toFormattedDateString();
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /**
     * Empty Size query scope.
     *
     * @param $query
     */
    public function scopeEmptySize($query)
    {
        /* @noinspection PhpUndefinedMethodInspection */
        $query->whereNull('size');
    }

    /**
     * Get files that fit specific type.
     *
     * @param $query
     * @param $extension_type
     */
    public function scopeWhereType($query, $extension_type)
    {
        $query->whereHas('extension', function ($query) use ($extension_type) {
            $query->where('type', $extension_type);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /**
     * This file has a original file.
     *
     * @return HasOne
     */
    public function originalFile()
    {
        // 6 --> this is the key for the relationship on the table defined on 4
        return $this->hasOne('App\File', 'id', 'original_file_id');
    }

    /**
     * This file has a FileExtension.
     *
     * @return HasOne
     */
    public function extension()
    {
        // 6 --> this is the key for the relationship on the table defined on 4
        return $this->hasOne('App\FileExtension', 'id', 'file_extension_id');
    }

    /**
     *  This file was created by a user.
     *
     * @return BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo('App\User', 'user_created_id', 'id');
    }

    /**
     *  This file was updated by a user.
     *
     * @return BelongsTo
     */
    public function updatedBy()
    {
        return $this->belongsTo('App\User', 'user_updated_id', 'id');
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    /**
     * Return a filename. This will remove the full path and the extension.
     *
     * @param $path
     *
     * @return mixed
     */
    public static function getFileNameFromPath($path)
    {
        $full_name = explode('/', $path);
        $full_name = end($full_name);

        return explode('.', $full_name)[0];
    }

    /**
     * Generate a base64 string of the image in question.
     *
     * @return string
     *
     * @throws FileNotFoundException
     */
    public function renderImage()
    {
        $img = Image::make(Storage::disk($this->driver)->get($this->getFullPath()));
        $type = $this->extension->name;
        $img->encode($type);

        return 'data:image/'.$type.';base64,'.base64_encode($img);
    }

    /**
     * Validate the given image.
     *
     * @param UploadedFile $file
     *
     * @return bool
     */
    public static function validateImage(UploadedFile $file)
    {
        // Check Size
        if (Helpers::getMaximumFileUploadSize() < $file->getSize()) {
            Helpers::flashAlert(
                'danger',
                'The file you are uploading is too big. Please try again with a smaller file.',
                'fa fa-info-circle mr-1');

            return false;
        }
        // Check Extension
        if (! FileExtension::isType('Graphics', $file)) {
            Helpers::flashAlert(
                'danger',
                'The file you are uploading does not match the type expected. Please upload an image file.',
                'fa fa-info-circle mr-1');

            return false;
        }

        return true;
    }

    /**
     * Save an uploaded file.
     *
     * @param UploadedFile $file
     * @param string       $driver
     * @param null         $filename
     *
     * @return bool
     */
    public static function saveTmpFile(UploadedFile $file, $driver = 'private', $filename = null)
    {
        $filename ?: $filename = Str::slug(explode('.', $file->getClientOriginalName())[0]);
        $tmp_path = env('FILE_TMP_DIRECTORY');
        $fullpath = $file->store($tmp_path);
        $local_name = static::getFileNameFromPath($fullpath);
        $extension = $file->getClientOriginalExtension();

        if ($extension !== $file->clientExtension()) {
            $extension = $file->clientExtension();
        }

        /* @noinspection PhpUndefinedMethodInspection */
        if (! $extension = FileExtension::where('name', $extension)->first()) {
            Helpers::flashAlert(
                'danger',
                'The type of file you are trying to upload is not recognized. Please try again.',
                'fa fa-info-circle mr-1');

            return false;
        }

        $file_model = new File();
        /* @noinspection PhpUndefinedMethodInspection */
        $file_model->file_extension_id = $extension->id;
        $file_model->path = $tmp_path;
        $file_model->size = Storage::disk($driver)->size($fullpath);
        $file_model->name = $local_name;
        $file_model->public_name = $filename;
        $file_model->driver = $driver;
        $file_model = Helpers::dbAddAudit($file_model);
        if (! $file_model->save()) {
            return false;
        }

        return $file_model;
    }

    /**
     * Quickly return the file model from a uuid.
     *
     * @param $uuid
     *
     * @return mixed
     */
    public static function getFile($uuid = 'json_encoded array')
    {
        $file_array = [];
        $uuid = json_decode($uuid);

        if (count($uuid) > 1) {
            foreach ($uuid as $id) {
                $file_array[] = static::where('uuid', $id)->first();
            }

            return $file_array;
        }

        return static::where('uuid', $uuid[0])->first();
    }

    /**
     * Rename the public name of a file and it's given original (if it has it).
     *
     * @param string $name
     *
     * @return bool|File
     */
    public function renameFile($name = 'pre-slug name')
    {
        if (! $this->update(['public_name' => Str::slug($name)])) {
            return false;
        }

        if ($original = $this->originalFile) {
            if (! $original->update(['public_name' => Str::slug($name)])) {
                return false;
            }
        }

        return true;
    }

    /**
     * Move an existing file from one directory to another.
     *
     * @param $new_path
     *
     * @return bool
     */
    public function moveFile($new_path)
    {
        if (! Storage::move($this->getFullPath(), $new_path.$this->getFileName())) {
            return false;
        }

        $this->update(['path' => $new_path]);

        return true;
    }

    /**
     * Check if the file is living in the tmp directory.
     *
     * @return bool
     */
    public function isTmp()
    {
        if ($this->path == env('FILE_TMP_DIRECTORY')) {
            return true;
        }

        return false;
    }

    /**
     * Rename and save permanently the given file.
     *
     * @param string $filename
     * @param string $path
     *
     * @return File|bool
     */
    public function saveFile($filename = '', $path = '')
    {
        if ($filename && ! $this->renameFile($filename)) {
            return false;
        }

        if ($path !== $this->path && ! $this->moveFile($path)) {
            return false;
        }

        return true;
    }

    /**
     * Save and resize and image.
     *
     * @param File $file
     * @param $path
     * @param $width
     * @param $height
     * @param string $driver
     *
     * @return bool
     *
     * @throws FileNotFoundException
     */
    protected static function saveResizedImage(File $file, $path, $width, $height, $driver = 'private')
    {
        $new_name = $file->name.'-resized';

        $img = Image::make(Storage::disk($driver)->get($file->getFullPath()))->resize($width, $height, function (Constraint $constraint) {
            $constraint->aspectRatio();
        });

        if (! Storage::disk($driver)->put("$path/$new_name.".$file->extension->name, $img->encode($file->extension->name))) {
            Helpers::flashAlert(
                'danger',
                'There was an issue processing your image. Please try again.',
                'fa fa-info-circle mr-1');

            return false;
        }

        $file_model = new File();
        /* @noinspection PhpUndefinedMethodInspection */
        $file_model->file_extension_id = $file->extension->id;
        $file_model->path = $path;
        $file_model->name = $new_name;
        $file_model->public_name = $file->public_name;
        $file_model->driver = $driver;
        $file_model->original_file_id = $file->id;
        $file_model = Helpers::dbAddAudit($file_model);
        if (! $file_model->save()) {
            Helpers::flashAlert(
                'danger',
                'There was an issue saving the file database record. Please try again.',
                'fa fa-info-circle mr-1');

            return false;
        }

        return $file_model;
    }

    /**
     * Take an uploaded file and save it's original full-sized copy, and then save a resized copy. Return
     * the resized model.
     *
     * @param File   $file
     * @param null   $filename
     * @param string $path
     * @param int    $width
     * @param int    $height
     * @param string $driver
     *
     * @return bool
     *
     * @throws FileNotFoundException
     */
    public static function saveAndResizeImage(File $file, $filename = null, $path = '', $width = 300, $height = 400, $driver = 'private')
    {
        $path ?: $path = env('FILE_PERMANENT_DIRECTORY');
        ! $filename ?: $file->renameFile($filename);
        $path == $file->path ?: $file->moveFile($path);

        /** @noinspection PhpParamsInspection */
        $resized_file = static::saveResizedImage($file, $path, $width, $height, $driver);

        if (! $resized_file) {
            Helpers::flashAlert(
                'danger',
                'The file uploaded was not processed correctly. Please try again.',
                'fa fa-info-circle mr-1');

            return false;
        }

        return $resized_file;
    }
}
