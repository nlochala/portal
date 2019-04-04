<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Storage;
use Webpatser\Uuid\Uuid;

class IdCard extends Model
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



// table name

// fillable
    /**
     * Add mass-assignment to model.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'name',
        'user_created_id',
        'user_created_ip',
        'user_updated_id',
        'user_updated_ip'
    ];

    public static $statusRadio = [
        'Cancelled',
        'Active'
    ];

    /**
     * Return a rendered copy of the sample idcard images.
     *
     * @param $type
     * @return bool
     * @throws FileNotFoundException
     */
    public static function sampleImage($type)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        if ($image = File::where('name', "sample-idcard-$type")->first()) {
            /** @noinspection PhpUndefinedMethodInspection */
            return $image->renderImage();
        }

        Storage::get('');

        return false;
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


    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */
    /**
     * This idCard has a File
     *
     * @return HasOne
     */
    public function frontImage()
    {
        // 6 --> this is the key for the relationship on the table defined on 4
        return $this->hasOne('App\File', 'id', 'front_image_file_id');
    }

    /**
     * This idCard has a File
     *
     * @return HasOne
     */
    public function backImage()
    {
        // 6 --> this is the key for the relationship on the table defined on 4
        return $this->hasOne('App\File', 'id', 'back_image_file_id');
    }

    /**
     *  This id_Card was created by a user
     *
     * @return BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo('App\User', 'user_created_by', 'id');
    }

    /**
     *  This id_Card was updated by a user
     *
     * @return BelongsTo
     */
    public function updatedBy()
    {
        return $this->belongsTo('App\User', 'user_updated_by', 'id');
    }
}
