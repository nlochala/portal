<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class GradeLevel extends PortalBaseModel
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


        // Order by name ASC
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('short_name', 'desc');
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
        'short_name',
        'name',
        'year_id',
        'school_id',
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
     * Return a formatted dropdown.
     *
     * @param null $scope
     * @param null $second_scope
     * @param bool $use_short_name
     * @return array
     */
    public static function getDropdown($scope = null, $second_scope = null, $use_short_name = true)
    {
        $name = $use_short_name ? 'short_name' : 'name';

        if ($scope) {
            if ($second_scope) {
                return static::$scope()->$second_scope()->get()->pluck($name, 'id')->toArray();
            }

            return static::$scope()->get()->pluck($name, 'id')->toArray();
        }

        return static::all()->pluck($name, 'id')->toArray();
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
     * Current year age levels query scope.
     *
     * @param $query
     */
    public function scopeCurrent($query)
    {
        $query->where('year_id', '=', env('SCHOOL_YEAR_ID'));
    }

    /**
     * Get grade query scope.
     *
     * @param $query
     * @param $grade
     */
    public function scopeGrade($query, $grade)
    {
        $query->where('short_name', '=', $grade);
    }

    /**
     * @param $query
     */
    public function scopeSecondary($query)
    {
        $query->where('short_name', '06')
            ->orWhere('short_name', '07')
            ->orWhere('short_name', '08')
            ->orWhere('short_name', '09')
            ->orWhere('short_name', '10')
            ->orWhere('short_name', '11')
            ->orWhere('short_name', '12');
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /**
     * Many grade_levels belongs to many courses.
     *
     * @return BelongsToMany
     */
    public function courses()
    {
        // belongsToMany('class','pivot_table','current_models_id','foreign_id')->withTimestamps()
        return $this->belongsToMany('App\Course', 'courses_grade_levels_pivot', 'grade_level_id', 'course_id')->withTimestamps();
    }

    /**
     *  This grade_level has many students.
     *
     * @return HasMany
     */
    public function students()
    {
        return $this->hasMany('App\Student', 'grade_level_id');
    }

    /**
     * This grade_level has a Year.
     *
     * @return HasOne
     */
    public function year()
    {
        // 6 --> this is the key for the relationship on the table defined on 4
        return $this->hasOne('App\Year', 'id', 'year_id');
    }

    /**
     * This grade_level has a School.
     *
     * @return HasOne
     */
    public function school()
    {
        // 6 --> this is the key for the relationship on the table defined on 4
        return $this->hasOne('App\School', 'id', 'school_id');
    }

    /**
     *  This grade_level was created by a user.
     *
     * @return BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo('App\User', 'user_created_id', 'id');
    }

    /**
     *  This grade_level was updated by a user.
     *
     * @return BelongsTo
     */
    public function updatedBy()
    {
        return $this->belongsTo('App\User', 'user_updated_id', 'id');
    }
}
