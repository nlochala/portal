<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class Visa extends Model
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



    /**
     * Add mass-assignment to model.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'passport_id',
        'visa_type_id',
        'image_file_id',
        'number',
        'issue_date',
        'is_active',
        'expiration_date',
        'visa_entry_id',
        'entry_duration',
        'user_created_id',
        'user_created_ip',
        'user_updated_id',
        'user_updated_ip'
    ];

    public static $statusRadio = [
        'Cancelled',
        'Active'
    ];

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

    /**
     * Set issue_date to carbon object
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
     * Set expiration_date to carbon object
     *
     * @param $value
     *
     * @return mixed
     */
    public function getExpirationDateAttribute($value)
    {
        return Carbon::parse($value);
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
     *  This visa belongs to a image
     *
     * @return BelongsTo
     */
    public function image()
    {
        return $this->belongsTo('App\File','image_file_id','id');
    }

    /**
     *  This visa belongs to a visaType
     *
     * @return BelongsTo
     */
    public function visaType()
    {
        return $this->belongsTo('App\VisaType','visa_type_id','id');
    }

    /**
     *  This visa belongs to a viseEntry
     *
     * @return BelongsTo
     */
    public function visaEntry()
    {
        return $this->belongsTo('App\VisaEntry','visa_entry_id','id');
    }

    /**
     *  This visa was created by a user
     *
     * @return BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo('App\User','user_created_by','id');
    }

    /**
     *  This visa was updated by a user
     *
     * @return BelongsTo
     */
    public function updatedBy()
    {
        return $this->belongsTo('App\User','user_updated_by','id');
    }
}
