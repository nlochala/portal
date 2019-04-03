<?php

namespace App;

use App\Helpers\Helpers;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Intervention\Image\Constraint;
use Intervention\Image\ImageManagerStatic as Image;
use Storage;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    /*
    |--------------------------------------------------------------------------
    | SETUP
    |--------------------------------------------------------------------------
    */
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];


    /*
    |--------------------------------------------------------------------------
    | ATTRIBUTES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */


    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */
    /**
     *  This uer belongs to a person
     *
     * @return BelongsTo
     */
    public function person()
    {
        return $this->belongsTo('App\Person', 'person_id', 'id');
    }


    /**
     * Many users belongs to many ad_groups
     *
     * @return BelongsToMany
     */
    public function adGroups()
    {
        // belongsToMany('class','pivot_table','current_models_id','foreign_id')->withTimestamps()
        return $this->belongsToMany('App\AdGroup', 'ad_groups_users_pivot', 'user_id', 'ad_group_id')->withTimestamps();
    }

    /**
     * This user has a File
     *
     * @return HasOne
     */
    public function thumbnail()
    {
        // 6 --> this is the key for the relationship on the table defined on 4
        return $this->hasOne('App\File', 'id', 'thumbnail_file_id');
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */
    public function saveProfileThumbnail()
    {
        // Get new name and attributes
        $img = $this->person->image;
        $new_name = $this->id . '-' . time();
        $new_fullname = $this->id . '-' . time() . '.' . $img->extension->name;
        $new_path = $img->path . '/thumbnails';
        $new_fullpath = $new_path . '/' . $new_fullname;

        // Process to thumbnail size
        $img_thumbnail = Image::make(Storage::get($img->getFullPath()))->resize(32, 32,
            function (Constraint $constraint) {
                $constraint->aspectRatio();
            });
        Storage::put($new_fullpath, $img_thumbnail->encode($img->extension->name));

        // Save the record of the new file
        $new_file = new File();
        $new_file->file_extension_id = $img->extension->id;
        $new_file->path = $new_path;
        $new_file->size = Storage::size($new_fullpath);
        $new_file->name = $new_name;
        $new_file->public_name = $new_name;
        $new_file->is_private = false;
        $new_file = Helpers::dbAddAudit($new_file);
        $new_file->save();

        $this->thumbnail_file_id = $new_file->id;
        $this->save();

        return true;
    }

    protected function renderThumbnail()
    {
        $img = Image::make(Storage::get($this->thumbnail->getFullPath()));
        $type = $this->thumbnail->extension->name;
        $img->encode($type);
        return 'data:image/' . $type . ';base64,' . base64_encode($img);
    }

    public function displayThumbnail()
    {
//        if ($this->person && $this->person->image && $this->thumbnail->id < 3) {
//            $this->saveProfileThumbnail();
//        }

        return $this->renderThumbnail();
    }
}
