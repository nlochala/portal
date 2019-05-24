<?php

namespace App;

use Carbon\Carbon;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Course extends PortalBaseModel
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

    public static $reportCardCheckbox = [
        'has_attendance' => 'Record Attendance',
        'show_on_report_card' => 'Include on Report Card',
        'calculate_report_card' => 'Calculate on Report Card',
    ];

    protected $casts = [
        'is_active' => 'bool',
        'has_attendance' => 'bool',
        'show_on_report_card' => 'bool',
        'calculate_report_card' => 'bool',
        'calculate_on_transcript' => 'bool',
        'is_protected' => 'bool',
    ];

    /**
     * Add mass-assignment to model.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'name',
        'name',
        'description',
        'short_name',
        'credits',
        'max_class_size',
        'is_active',
        'has_attendance',
        'show_on_report_card',
        'calculate_report_card',
        'calculate_on_transcript',
        'course_transcript_type_id',
        'grade_scale_id',
        'department_id',
        'course_type_id',
        'year_id',
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
    | ATTRIBUTES
    |--------------------------------------------------------------------------
    */

    /**
     * Return a formatted name.
     *
     * @return mixed
     */
    public function getFullNameAttribute()
    {
        return $this->short_name.' - '.$this->name;
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
     * Get active courses query scope.
     *
     * @param $query
     */
    public function scopeActive($query)
    {
        $query->where('is_active', true);
    }

    /**
     * Get active courses query scope.
     *
     * @param $query
     */
    public function scopeCurrent($query)
    {
        $query->where('is_active', true);
    }

    /**
     * Get inactive courses query scope.
     *
     * @param $query
     */
    public function scopeInactive($query)
    {
        $query->where('is_active', false);
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /**
     * Many courses belongs to many courses.
     *
     * @return BelongsToMany
     */
    public function prerequisites()
    {
        // belongsToMany('class','pivot_table','current_models_id','foreign_id')->withTimestamps()
        return $this->belongsToMany('App\Course', 'courses_prerequisites_pivot', 'course_id', 'requires_course_id')->withTimestamps();
    }

    /**
     * Many courses belongs to many courses.
     *
     * @return BelongsToMany
     */
    public function corequisites()
    {
        // belongsToMany('class','pivot_table','current_models_id','foreign_id')->withTimestamps()
        return $this->belongsToMany('App\Course', 'courses_corequisites_pivot', 'course_id', 'requires_course_id')->withTimestamps();
    }

    /**
     * Many courses belongs to many courses.
     *
     * @return BelongsToMany
     */
    public function equivalents()
    {
        // belongsToMany('class','pivot_table','current_models_id','foreign_id')->withTimestamps()
        return $this->belongsToMany('App\Course', 'courses_equivalents_pivot', 'course_id', 'equivalent_to_course_id')->withTimestamps();
    }

    /**
     * Many courses belongs to many grade_levels.
     *
     * @return BelongsToMany
     */
    public function gradeLevels()
    {
        // belongsToMany('class','pivot_table','current_models_id','foreign_id')->withTimestamps()
        return $this->belongsToMany('App\GradeLevel', 'courses_grade_levels_pivot', 'course_id', 'grade_level_id')->withTimestamps();
    }

    /**
     * This course has a CourseType.
     *
     * @return HasOne
     */
    public function type()
    {
        // 6 --> this is the key for the relationship on the table defined on 4
        return $this->hasOne('App\CourseType', 'id', 'course_type_id');
    }

    /**
     * This course has a CourseTranscriptType.
     *
     * @return HasOne
     */
    public function transcriptType()
    {
        // 6 --> this is the key for the relationship on the table defined on 4
        return $this->hasOne('App\CourseTranscriptType', 'id', 'course_transcript_type_id');
    }

    /**
     * This course has a GradeScale.
     *
     * @return HasOne
     */
    public function gradeScale()
    {
        // 6 --> this is the key for the relationship on the table defined on 4
        return $this->hasOne('App\GradeScale', 'id', 'grade_scale_id');
    }

    /**
     * This course has a Department.
     *
     * @return HasOne
     */
    public function department()
    {
        // 6 --> this is the key for the relationship on the table defined on 4
        return $this->hasOne('App\Department', 'id', 'department_id');
    }

    /**
     * This course has a Year.
     *
     * @return HasOne
     */
    public function year()
    {
        // 6 --> this is the key for the relationship on the table defined on 4
        return $this->hasOne('App\Year', 'id', 'year_id');
    }

    /**
     *  This course was created by a user.
     *
     * @return BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo('App\User', 'user_created_id', 'id');
    }

    /**
     *  This course was updated by a user.
     *
     * @return BelongsTo
     */
    public function updatedBy()
    {
        return $this->belongsTo('App\User', 'user_updated_id', 'id');
    }
}
