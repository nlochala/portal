<?php

namespace App;

use App\Helpers\Helpers;
use Carbon\Carbon;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Intervention\Image\Constraint;
use Intervention\Image\ImageManagerStatic as Image;
use Storage;
use Webpatser\Uuid\Uuid;

class File extends Model
{
    use SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | SETUP
    |--------------------------------------------------------------------------
    */
    /**
     *  Setup model event hooks
     */
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string)Uuid::generate(4);
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
        'user_updated_ip'
    ];

    /**
     * Generate a url for download the given file
     *
     * @return UrlGenerator|string
     */
    public function downloadUrl()
    {
        return url('/download_file/' . $this->uuid);
    }

    /**
     * This will return the full path plus filename/extension
     *
     * @return string
     */
    public function getFullPath()
    {
        $this->path ? $path = $this->path . '/' : $path = '';
        return $path . $this->getFileName();
    }

    /**
     * This will return the full filename with extension
     *
     * @return string
     */
    public function getFileName()
    {
        return $this->name . '.' . $this->extension->name;
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
     * Set created_at to Carbon Object
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
     * Set updated_at to Carbon Object
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
     * Empty Size query scope
     *
     * @param $query
     */
    public function scopeEmptySize($query)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $query->whereNull('size');
    }


    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */
    /**
     * This file has a original file
     *
     * @return HasOne
     */
    public function originalFile()
    {
        // 6 --> this is the key for the relationship on the table defined on 4
        return $this->hasOne('App\File', 'id', 'original_file_id');
    }

    /**
     * This file has a FileExtension
     *
     * @return HasOne
     */
    public function extension()
    {
        // 6 --> this is the key for the relationship on the table defined on 4
        return $this->hasOne('App\FileExtension', 'id', 'file_extension_id');
    }

    /**
     *  This file was created by a user
     *
     * @return BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo('App\User', 'user_created_by', 'id');
    }

    /**
     *  This file was updated by a user
     *
     * @return BelongsTo
     */
    public function updatedBy()
    {
        return $this->belongsTo('App\User', 'user_updated_by', 'id');
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
     * @return mixed
     */
    public static function getFileNameFromPath($path)
    {
        $full_name = explode('/', $path);
        $full_name = end($full_name);
        return explode('.', $full_name)[0];
    }

    /**
     * Generate a base64 string of the image in question
     *
     * @return string
     * @throws FileNotFoundException
     */
    public function renderImage()
    {
        $img = Image::make(Storage::disk($this->driver)->get($this->getFullPath()));
        $type = $this->extension->name;
        $img->encode($type);
        return 'data:image/' . $type . ';base64,' . base64_encode($img);
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
        if (!FileExtension::isType('Graphics', $file)) {
            Helpers::flashAlert(
                'danger',
                'The file you are uploading does not match the type expected. Please upload an image file.',
                'fa fa-info-circle mr-1');
            return false;
        }

        return true;
    }

    /**
     * Save an uploaded file
     *
     * @param UploadedFile $file
     * @param $path
     * @param string $driver
     * @param null $filename
     * @return bool
     */
    public static function saveFile(UploadedFile $file, $driver = 'private', $filename = null, $path = '')
    {
        $filename ?: $filename = Str::slug(explode('.', $file->getClientOriginalName())[0]);

        $fullpath = $file->store($path);
        $local_name = static::getFileNameFromPath($fullpath);

        $extension = $file->getClientOriginalExtension();

        if ($file->getClientOriginalExtension() !== $file->clientExtension()) {
            $extension = $file->clientExtension();
        }

        $file_model = new File();
        /** @noinspection PhpUndefinedMethodInspection */
        $file_model->file_extension_id = FileExtension::where('name', $extension)->first()->id;
        $file_model->path = $path;
        $file_model->size = Storage::disk($driver)->size($fullpath);
        $file_model->name = $local_name;
        $file_model->public_name = $filename;
        $file_model->driver = $driver;
        $file_model = Helpers::dbAddAudit($file_model);
        if (!$file_model->save()) {
            return false;
        }

        return $file_model;
    }

    /**
     * Save and resize and image
     *
     * @param File $file
     * @param $path
     * @param $width
     * @param $height
     * @param string $driver
     * @return bool
     * @throws FileNotFoundException
     */
    protected static function saveResizedImage(File $file, $path, $width, $height, $driver = 'private')
    {
        $new_name = $file->name . time();

        $img = Image::make(Storage::disk($driver)->get($file->getFullPath()))->resize($width, $height, function (Constraint $constraint) {
            $constraint->aspectRatio();
        });

        if (!Storage::disk($driver)->put("$path/$new_name." . $file->extension->name, $img->encode($file->extension->name))) {
            Helpers::flashAlert(
                'danger',
                'There was an issue processing your image. Please try again.',
                'fa fa-info-circle mr-1');

            return false;
        }

        $file_model = new File();
        /** @noinspection PhpUndefinedMethodInspection */
        $file_model->file_extension_id = $file->extension->id;
        $file_model->path = $path;
        $file_model->name = $new_name;
        $file_model->public_name = $file->public_name;
        $file_model->driver = $driver;
        $file_model = Helpers::dbAddAudit($file_model);
        if (!$file_model->save()) {
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
     * @param UploadedFile $file
     * @param null $filename
     * @param string $path
     * @param string $original_path
     * @param int $width
     * @param int $height
     * @param string $driver
     * @return bool
     * @throws FileNotFoundException
     */
    public static function saveAndResizeImage(UploadedFile $file, $filename = null, $path = '', $original_path = '', $width = 300, $height = 400, $driver = 'private')
    {
        if (!File::validateImage($file)) {
            Helpers::flashAlert(
                'danger',
                'The file uploaded was not an image. The file should be an image. Please try again.',
                'fa fa-info-circle mr-1');
            return false;
        }

        if (!$original_file = static::saveFile($file, $driver, $filename, $original_path)) {
            Helpers::flashAlert(
                'danger',
                'There was a problem saving the original file. Please try again.',
                'fa fa-info-circle mr-1');
            return false;
        }

        /** @noinspection PhpParamsInspection */
        $resized_file = static::saveResizedImage($original_file, $path, $width, $height, $driver);

        if (!$resized_file) {
            Helpers::flashAlert(
                'danger',
                'The file uploaded was not processed correctly. Please try again.',
                'fa fa-info-circle mr-1');
            return false;
        }

        /** @noinspection PhpUndefinedMethodInspection */
        $resized_file->update(['original_file_id' => $original_file->id]);

        return $resized_file;
    }
}
