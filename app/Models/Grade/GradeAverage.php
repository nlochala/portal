<?php

namespace App;

use Carbon\Carbon;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GradeAverage extends PortalBaseModel
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
        'quarter_id',
        'student_id',
        'class_id',
        'assignment_type_id',
        'grade_scale_id',
        'max_points',
        'points_earned',
        'bonus_points',
        'is_protected',
        'user_created_id',
        'user_created_ip',
        'user_updated_id',
        'user_updated_ip',
    ];

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    public static function averageByStudent(Student $student, CourseClass $class, Quarter $quarter)
    {
        $grades = $student->gradeAverages->where('class_id', $class->id)->where('quarter_id', $quarter->id);

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
     * quarter query scope.
     *
     * @param $query
     * @param $quarter_id
     */
    public function scopeIsQuarter($query, $quarter_id)
    {
        $query->where('quarter_id', '=', $quarter_id);
    }

    /**
     * Student query scope.
     *
     * @param $query
     * @param $student_id
     */
    public function scopeIsStudent($query, $student_id)
    {
        $query->where('student_id', '=', $student_id);
    }

    /**
     * Class query scope.
     *
     * @param $query
     * @param $class_id
     */
    public function scopeIsClass($query, $class_id)
    {
        $query->where('class_id', '=', $class_id);
    }

    /**
     * Assignment Type query scope.
     *
     * @param $query
     * @param $assignment_type_id
     */
    public function scopeIsAssignmentType($query, $assignment_type_id)
    {
        $query->where('assignment_type_id', '=', $assignment_type_id);
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /**
     * This grade_average has a Quarter.
     *
     * @return HasOne
     */
    public function quarter()
    {
        // 6 --> this is the key for the relationship on the table defined on 4
        return $this->hasOne('App\Quarter', 'id', 'quarter_id');
    }

    /**
     * This grade average has a Student.
     *
     * @return HasOne
     */
    public function student()
    {
        // 6 --> this is the key for the relationship on the table defined on 4
        return $this->hasOne('App\Student', 'id', 'student_id');
    }

    /**
     * This grade average has a CourseClass.
     *
     * @return HasOne
     */
    public function class()
    {
        // 6 --> this is the key for the relationship on the table defined on 4
        return $this->hasOne('App\CourseClass', 'id', 'class_id');
    }

    /**
     * This grade average has a AssignmentType.
     *
     * @return HasOne
     */
    public function assignmentType()
    {
        // 6 --> this is the key for the relationship on the table defined on 4
        return $this->hasOne('App\AssignmentType', 'id', 'assignment_type_id');
    }

    /**
     * This grade average has a GradeScale.
     *
     * @return HasOne
     */
    public function gradeScale()
    {
        // 6 --> this is the key for the relationship on the table defined on 4
        return $this->hasOne('App\GradeScale', 'id', 'grade_scale_id');
    }

    /**
     *  This grade_average was created by a user.
     *
     * @return BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo('App\User', 'user_created_id', 'id');
    }

    /**
     *  This grade_average was updated by a user.
     *
     * @return BelongsTo
     */
    public function updatedBy()
    {
        return $this->belongsTo('App\User', 'user_updated_id', 'id');
    }
}
