<?php

namespace App;

use Carbon\Carbon;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssignmentType extends PortalBaseModel
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

    protected $casts = ['is_protected' => 'bool'];

    /**
     * Add mass-assignment to model.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'class_id',
        'name',
        'weight',
        'description',
        'is_protected',
        'user_created_id',
        'user_created_ip',
        'user_updated_id',
        'user_updated_ip',
    ];

    /**
     * Return a formatted dropdown.
     *
     * @param null $scope
     * @param string $scope_parameter
     * @return array
     */
    public static function getDropdown($scope = null, $scope_parameter = '')
    {
        if ($scope) {
            return static::$scope($scope_parameter)->get()->pluck('name', 'id')->toArray();
        }

        return static::all()->pluck('name', 'id')->toArray();
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
     * Class query scope.
     *
     * @param $query
     */
    public function scopeCourseClass($query, $class_id)
    {
        $query->where('class_id', '=', $class_id);
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /**
     *  This assignment_type has many gradeAverages.
     *
     * @return HasMany
     */
    public function gradeAverages()
    {
        return $this->hasMany('App\GradeAverage', 'assignment_type_id');
    }

    /**
     *  This assignment_type has many assignments.
     *
     * @return HasMany
     */
    public function assignments()
    {
        return $this->hasMany('App\Assignment', 'assignment_type_id');
    }

    /**
     * This assignment_type has a CourseClass.
     *
     * @return HasOne
     */
    public function class()
    {
        // 6 --> this is the key for the relationship on the table defined on 4
        return $this->hasOne('App\CourseClass', 'id', 'class_id');
    }

    /**
     *  This assignment_type was created by a user.
     *
     * @return BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo('App\User', 'user_created_id', 'id');
    }

    /**
     *  This assignment_type was updated by a user.
     *
     * @return BelongsTo
     */
    public function updatedBy()
    {
        return $this->belongsTo('App\User', 'user_updated_id', 'id');
    }
}
