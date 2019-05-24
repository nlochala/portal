<?php

namespace App;

use Carbon\Carbon;
use Collective\Html\Eloquent\FormAccessible;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class IdCard extends Model
{
    use SoftDeletes;
    use FormAccessible;

    /*
    |--------------------------------------------------------------------------
    | SETUP
    |--------------------------------------------------------------------------
    */

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
        'person_id',
        'front_image_file_id',
        'back_image_file_id',
        'is_active',
        'number',
        'name',
        'issue_date',
        'expiration_date',
        'user_created_id',
        'user_created_ip',
        'user_updated_id',
        'user_updated_ip',
    ];

    public static $statusRadio = [
        'Cancelled',
        'Active',
    ];

    /**
     * Return a rendered copy of the sample idcard images.
     *
     * @param $type
     *
     * @return bool
     */
    public static function sampleImage($type)
    {
        /* @noinspection PhpUndefinedMethodInspection */
        if ($image = File::where('name', "sample-idcard-$type")->first()) {
            /* @noinspection PhpUndefinedMethodInspection */
            return $image;
        }

        return false;
    }

    /*
    |--------------------------------------------------------------------------
    | ATTRIBUTES
    |--------------------------------------------------------------------------
    */

    /**
     * Set issue_date to carbon object.
     *
     * @param $value
     *
     * @return mixed
     */
    public function getIssueDateAttribute($value)
    {
        return Carbon::parse($value);
    }

    /**
     * Set expiration_date to carbon object.
     *
     * @param $value
     *
     * @return mixed
     */
    public function getExpirationDateAttribute($value)
    {
        return Carbon::parse($value);
    }

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

    /**
     * Get the passport's IssueDate for forms.
     *
     * @param string $value
     *
     * @return string
     */
    public function formIssueDateAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }

    /**
     * Get the passport's ExpirationDate for forms.
     *
     * @param string $value
     *
     * @return string
     */
    public function formExpirationDateAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
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
     * This idCard has a File.
     *
     * @return HasOne
     */
    public function frontImage()
    {
        // 6 --> this is the key for the relationship on the table defined on 4
        return $this->hasOne('App\File', 'id', 'front_image_file_id');
    }

    /**
     * This idCard has a File.
     *
     * @return HasOne
     */
    public function backImage()
    {
        // 6 --> this is the key for the relationship on the table defined on 4
        return $this->hasOne('App\File', 'id', 'back_image_file_id');
    }

    /**
     *  This id_Card was created by a user.
     *
     * @return BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo('App\User', 'user_created_id', 'id');
    }

    /**
     *  This id_Card was updated by a user.
     *
     * @return BelongsTo
     */
    public function updatedBy()
    {
        return $this->belongsTo('App\User', 'user_updated_id', 'id');
    }
}
