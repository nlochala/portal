<?php

namespace App;

use Carbon\Carbon;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Year extends PortalBaseModel
{
    use SoftDeletes;

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
        'year_start',
        'year_end',
        'start_date',
        'end_date',
        'user_created_id',
        'user_created_ip',
        'user_updated_id',
        'user_updated_ip',
    ];

    /*
    |--------------------------------------------------------------------------
    | STATIC METHODS
    |--------------------------------------------------------------------------
    */

    /**
     * Return the current school year.
     *
     * @return mixed
     */
    public static function currentYear()
    {
        return Year::findOrFail(env('SCHOOL_YEAR_ID'));
    }

    /**
     * Return a formatted dropdown.
     *
     * @param null $scope
     * @return array
     */
    public static function getDropdown($scope = null)
    {
        if ($scope) {
            return static::$scope()->get()->pluck('name', 'id')->toArray();
        }

        return static::all()->pluck('name', 'id')->toArray();
    }

    /*
    |--------------------------------------------------------------------------
    | METHODS
    |--------------------------------------------------------------------------
    */

    /**
     * Check if the given year is the current school year.
     *
     * @return bool
     */
    public function isCurrentYear()
    {
        return $this->id === env('SCHOOL_YEAR_ID');
    }

    /*
    |--------------------------------------------------------------------------
    | ATTRIBUTES
    |--------------------------------------------------------------------------
    */

    /**
     * Get year name.
     *
     * @return mixed
     */
    public function getNameAttribute()
    {
        return "$this->year_start-$this->year_end";
    }

    /**
     * Get start_date as Carbon Object.
     *
     * @param $value
     *
     * @return mixed
     */
    public function getStartDateAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }

    /**
     * Get end_date as Carbon Object.
     *
     * @param $value
     *
     * @return mixed
     */
    public function getEndDateAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
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

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /**
     * current and future years query scope.
     *
     * @param $query
     */
    public function scopeCurrentFuture($query)
    {
        $query->where('id', '>=', env('SCHOOL_YEAR_ID'));
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /**
     *  This year has many quarters.
     *
     * @return HasMany
     */
    public function quarters()
    {
        return $this->hasMany('App\Quarter', 'year_id');
    }

    /**
     *  This year was created by a user.
     *
     * @return BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo('App\User', 'user_created_id', 'id');
    }

    /**
     *  This year was updated by a user.
     *
     * @return BelongsTo
     */
    public function updatedBy()
    {
        return $this->belongsTo('App\User', 'user_updated_id', 'id');
    }
}
