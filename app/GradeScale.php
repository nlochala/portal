<?php

namespace App;

use Carbon\Carbon;
use Webpatser\Uuid\Uuid;
use Whoops\Exception\ErrorException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GradeScale extends Model
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

    protected $casts = [
        'is_percentage_based' => 'bool',
        'is_standards_based' => 'bool',
    ];

    /**
     * Add mass-assignment to model.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'name',
        'description',
        'is_percentage_based',
        'is_standards_based',
        'user_created_id',
        'user_created_ip',
        'user_updated_id',
        'user_updated_ip',
    ];

    /**
     * Return the scale type.
     *
     * @return string
     */
    public function getScaleType()
    {
        if ($this->is_percentage_based) {
            return 'percentage';
        }

        if ($this->is_standards_based) {
            return 'standards';
        }
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

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /**
     *  This grade_scale has many items.
     *
     * @return HasMany
     */
    public function items()
    {
        if ($this->is_percentage_based) {
            return $this->hasMany('App\GradeScalePercentage', 'grade_scale_id');
        }

        if ($this->is_standards_based) {
            return $this->hasMany('App\GradeScaleStandard', 'grade_scale_id');
        }

        return throwException(new ErrorException(
            'The grade scale must be either percentage-based or standards-based. This grade scale is neither.'
        ));
    }

    /**
     *  This grade_scale was created by a user.
     *
     * @return BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo('App\User', 'user_created_id', 'id');
    }

    /**
     *  This grade_scale was updated by a user.
     *
     * @return BelongsTo
     */
    public function updatedBy()
    {
        return $this->belongsTo('App\User', 'user_updated_id', 'id');
    }
}
