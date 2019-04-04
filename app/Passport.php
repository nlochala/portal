<?php

namespace App;

use Carbon\Carbon;
use Collective\Html\Eloquent\FormAccessible;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class Passport extends Model
{
    use SoftDeletes;
    use FormAccessible;

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
        'person_id',
        'country_id',
        'image_file_id',
        'family_name',
        'given_name',
        'number',
        'issue_date',
        'is_active',
        'expiration_date',
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
     * Return the status of a passport
     *
     * @param Int $status
     * @return mixed
     */
    public static function getStatus(Int $status)
    {
        return static::$statusRadio[$status];
    }

    /**
     * Return a rendered copy of the sample passport image.
     *
     * @return mixed
     */
    public static function getSampleImage()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return File::where('name', 'sample-passport')->first()->renderImage();
    }

    /*
    |--------------------------------------------------------------------------
    | ATTRIBUTES
    |--------------------------------------------------------------------------
    */
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
     * Get the passport's IssueDate for forms.
     *
     * @param string $value
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
     *  This passport has many visas
     *
     * @return HasMany
     */
    public function visas()
    {
        return $this->hasMany('App\Visa', 'passport_id');
    }

    /**
     *  This passport belongs to a person
     *
     * @return BelongsTo
     */
    public function person()
    {
        return $this->belongsTo('App\Person', 'person_id', 'id');
    }

    /**
     *  This passport belongs to a image
     *
     * @return BelongsTo
     */
    public function image()
    {
        return $this->belongsTo('App\File', 'image_file_id', 'id');
    }

    /**
     *  This passport belongs to a country
     *
     * @return BelongsTo
     */
    public function country()
    {
        return $this->belongsTo('App\Country', 'country_id', 'id');
    }

    /**
     *  This passport was created by a user
     *
     * @return BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo('App\User', 'user_created_by', 'id');
    }

    /**
     *  This passport was updated by a user
     *
     * @return BelongsTo
     */
    public function updatedBy()
    {
        return $this->belongsTo('App\User', 'user_updated_by', 'id');
    }
}
