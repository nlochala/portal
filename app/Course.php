<?php

namespace App;

use Carbon\Carbon;
use Webpatser\Uuid\Uuid;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'is_active' => 'Activate Course',
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
            return static::$scope()->get()->pluck('full_name', 'id')->toArray();
        }

        return static::all()->pluck('full_name', 'id')->toArray();
    }

    /*
    |--------------------------------------------------------------------------
    | ATTRIBUTES
    |--------------------------------------------------------------------------
    */

    /**
     * Prerequisites display.
     *
     * @return mixed
     */
    public function getDisplayInlinePrerequisitesAttribute()
    {
        return $this->prerequisites->isEmpty()
            ? '---'
            : implode(', ', $this->prerequisites->pluck('short_name_url')->toArray());
    }

    /**
     * Corequisites display.
     *
     * @return mixed
     */
    public function getDisplayInlineCorequisitesAttribute()
    {
        return $this->corequisites->isEmpty()
            ? '---'
            : implode(', ', $this->corequisites->pluck('short_name_url')->toArray());
    }

    /**
     * Equivalents display.
     *
     * @return mixed
     */
    public function getDisplayInlineEquivalentsAttribute()
    {
        return $this->equivalents->isEmpty()
            ? '---'
            : implode(', ', $this->equivalents->pluck('short_name_url')->toArray());
    }

    /**
     * Equivalents display.
     *
     * @return mixed
     */
    public function getDisplayInlineGradeLevelsAttribute()
    {
        return $this->gradeLevels->isEmpty()
            ? '---'
            : implode(', ', $this->gradeLevels->pluck('short_name')->toArray());
    }

    /**
     * Return url-formatted short_name.
     *
     * @return mixed
     */
    public function getShortNameUrlAttribute()
    {
        return '<a href="'.url('course/'.$this->uuid).'">'.$this->short_name.'</a>';
    }

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

    /**
     * Show all homeroom courses.
     *
     * @param $query
     */
    public function scopeHomeroom($query)
    {
        $query->where('course_type_id', 2)
            ->orWhere('department_id', 9);
    }

    /**
     * gradeLevel query scope.
     *
     * @param $query
     * @param $grades
     */
    public function scopeGradeLevel($query, $grades)
    {
        if (is_int($grades)) {
            $grades = [$grades];
        }

        if ($grades instanceof Collection) {
            $grades = $grades->pluck('id')->toArray();
        }

        $query->whereHas('gradeLevels', function ($q) use ($grades) {
            $q->whereIn('grade_level_id', $grades);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /**
     *  This course has many classes.
     *
     * @return HasMany
     */
    public function classes()
    {
        return $this->hasMany('App\CourseClass', 'course_id');
    }

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

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    /**
     * @param $filter
     * @return bool|array
     */
    public function getEnrollmentLists($filter)
    {
        $options = [];

        if ($filter === 'homeroom') {
            if ($this->gradeLevels->isEmpty()) {
                return false;
            }

            $courses = Course::gradeLevel($this->gradeLevels)
                ->active()
                ->homeroom()
                ->with(
                    'classes.q1students.person',
                    'classes.q2students.person',
                    'classes.q3students.person',
                    'classes.q4students.person'
                )->get();
        }

        /* @noinspection PhpVariableVariableInspection */
        if ($this->$filter->isEmpty()) {
            return false;
        }

        /* @noinspection PhpVariableVariableInspection */
        foreach ($this->$filter as $subitem) {
            $options[$subitem->short_name] =
                $subitem->students()->current()->with('person')->get()->pluck('full_name', 'id')->toArray();
        }

        return $options;
    }
}
