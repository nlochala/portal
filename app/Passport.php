<?php

namespace App;

use Carbon\Carbon;
use Collective\Html\Eloquent\FormAccessible;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

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
     * Add mass-assignment to model.
     *
     * @var array
     */
    protected $fillable = [
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

    /**
     * Return the proper badge for the expiration date
     *
     * @return string
     */
    public function getExpirationBadge()
    {
        if($this->expiration_date->isPast()){
           return '<span class="badge badge-dark"><i class="fa fa-pause-circle"></i> EXPIRED</span>';
        }

        switch ($x = $this->expiration_date->diffInDays()) {
            case $x < 180:
                $color = 'danger';
                $icon = 'fa fa-calendar-times';
                break;
            case $x < 365:
                $color = 'warning';
                $icon = 'fa fa-exclamation-circle';
                break;
            default:
                $color = 'primary';
                $icon = 'fa fa-check';
                break;
        }

        return '<span class="badge badge-'
            . $color . '"><i class="' . $icon . '"></i> Passport expires '
            . $this->expiration_date->diffForHumans() . '!</span>';
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
