<?php

namespace App;

use Carbon\Carbon;
use Webpatser\Uuid\Uuid;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CourseClass extends PortalBaseModel
{
    use SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | SETUP
    |--------------------------------------------------------------------------
    */

    /**
     * The database table (classes) used by the model.
     *
     * @var string
     */
    protected $table = 'classes';

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
        'name',
        'course_id',
        'primary_employee_id',
        'secondary_employee_id',
        'ta_employee_id',
        'room_id',
        'year_id',
        'class_status_id',
        'is_protected',
        'user_created_id',
        'user_created_ip',
        'user_updated_id',
        'user_updated_ip',
    ];

    /**
     * Generate the full name with the choice of a url.
     *
     * @param bool $include_url
     * @return string
     */
    public function fullName($include_url = false)
    {
        return $include_url
            ? '<a href="/course/'.$this->course->uuid.'">'.$this->course->short_name.'</a>: '.$this->name
            : $this->full_name;
    }

    /**
     * When given an employee, determine which kind of teacher
     * he or she is.
     *
     * @param Employee $employee
     * @return string
     */
    public function getTeacherType(Employee $employee)
    {
        $type = '--';

        switch ($employee->id) {
            case $this->primary_employee_id:
                $type = 'Primary Teacher';
                break;
            case $this->secondary_employee_id:
                $type = 'Secondary Teacher';
                break;
            case $this->ta_employee_id:
                $type = 'Teaching Assistant';
                break;
        }

        return $type;
    }

    /**
     * Return all classes that need attendance.
     *
     * @return mixed
     */
    public static function classesWithAttendance()
    {
        return static::whereHas('course', function ($q) {
            $q->active()->hasAttendance();
        })->get();
    }

    /**
     * Display the teachers of a given class.
     *
     * @param bool $display_inline
     * @return string
     */
    public function getTeachers($display_inline = false)
    {
        $break = $display_inline ? ' | ' : '<br />';
        $teachers = '';
        $teachers .= '<strong>Primary Teacher: </strong><a href="/employee/'.$this->primaryEmployee->uuid.'">'.$this->primaryEmployee->full_name.'</a>';

        if ($this->secondaryEmployee) {
            $teachers .= $break.'<strong>Secondary Teacher: </strong><a href="/employee/'.$this->secondaryEmployee->uuid.'">'.$this->secondaryEmployee->full_name.'</a>';
        }

        if ($this->taEmployee) {
            $teachers .= $break.'<strong>Assistant Teacher: </strong><a href="/employee/'.$this->taEmployee->uuid.'">'.$this->taEmployee->full_name.'</a>';
        }

        return $teachers;
    }

    /**
     * Return today's attendance for a class.
     *
     * @return mixed
     */
    public function todaysAttendance()
    {
        return $this->attendance()->today()->get();
    }

    /**
     * Return today's attendance for a class.
     *
     * @param string $date
     * @return mixed
     */
    public function attendanceOn($date = 'Y-m-d')
    {
        return $this->attendance()->date($date)->get();
    }

    /**
     * Can this class take attendance?
     *
     * @return bool
     */
    public function canTakeAttendance()
    {
        return $this->course->has_attendance ? true : false;
    }

    /**
     * Return the current students.
     *
     * @param Quarter $quarter
     * @param string $status
     * @return mixed
     */
    public function currentStudents(Quarter $quarter, $status = 'current')
    {
        $relationship = $quarter->getClassRelationship();

        return $this->$relationship()->$status()->with('person', 'status')->get()->sortBy('person.preferred_name');
    }

    /*
    |--------------------------------------------------------------------------
    | ATTRIBUTES
    |--------------------------------------------------------------------------
    */

    /**
     * Return the formatted full name.
     *
     * @return mixed
     */
    public function getFullNameAttribute()
    {
        return $this->course->short_name.': '.$this->name;
    }

    /**
     * Get a list of all the students that are enrolled in a class, regardless of quarter.
     *
     * @return mixed
     */
    public function getStudentsAttribute()
    {
        $students = new Collection();

        $q1 = $this->q1Students()->current()->with('person')->get();
        $merged = $students->merge($q1);

        $q2 = $this->q2Students()->current()->with('person')->get();
        $merged = $merged->merge($q2);

        $q3 = $this->q3Students()->current()->with('person')->get();
        $merged = $merged->merge($q3);

        $q4 = $this->q4Students()->current()->with('person')->get();
        $merged = $merged->merge($q4);

        return $merged->unique('id');
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
     * Standards-based query scope.
     *
     * @param $query
     */
    public function scopeIsStandardsBased($query)
    {
        $query->whereHas('course', function ($q) {
            $q->whereHas('gradeScale', function ($q1) {
                $q1->where('is_standards_based', true);
            });
        });
    }

    /**
     * Percentage-based query scope.
     *
     * @param $query
     */
    public function scopeIsPercentageBased($query)
    {
        $query->whereHas('course', function ($q) {
            $q->whereHas('gradeScale', function ($q1) {
                $q1->where('is_percentage_based', true);
            });
        });
    }

    /**
     * Return active classes query scope.
     *
     * @param $query
     */
    public function scopeActive($query)
    {
        $query->where('class_status_id', '=', '1');
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /**
     *  This class has many attendance.
     *
     * @return HasMany
     */
    public function attendance()
    {
        return $this->hasMany('App\AttendanceClass', 'class_id');
    }

    /**
     * Many classes belongs to many students.
     *
     * @return BelongsToMany
     */
    public function q1Students()
    {
        // belongsToMany('class','pivot_table','current_models_id','foreign_id')->withTimestamps()
        return $this->belongsToMany('App\Student', 'q1_classes_students_pivot', 'class_id', 'student_id')->withTimestamps();
    }

    /**
     * Many classes belongs to many students.
     *
     * @return BelongsToMany
     */
    public function q2Students()
    {
        // belongsToMany('class','pivot_table','current_models_id','foreign_id')->withTimestamps()
        return $this->belongsToMany('App\Student', 'q2_classes_students_pivot', 'class_id', 'student_id')->withTimestamps();
    }

    /**
     * Many classes belongs to many students.
     *
     * @return BelongsToMany
     */
    public function q3Students()
    {
        // belongsToMany('class','pivot_table','current_models_id','foreign_id')->withTimestamps()
        return $this->belongsToMany('App\Student', 'q3_classes_students_pivot', 'class_id', 'student_id')->withTimestamps();
    }

    /**
     * Many classes belongs to many students.
     *
     * @return BelongsToMany
     */
    public function q4Students()
    {
        // belongsToMany('class','pivot_table','current_models_id','foreign_id')->withTimestamps()
        return $this->belongsToMany('App\Student', 'q4_classes_students_pivot', 'class_id', 'student_id')->withTimestamps();
    }

    /**
     *  This class belongs to a primaryEmployee.
     *
     * @return BelongsTo
     */
    public function primaryEmployee()
    {
        return $this->belongsTo('App\Employee', 'primary_employee_id', 'id');
    }

    /**
     *  This class belongs to a secondaryEmployee.
     *
     * @return BelongsTo
     */
    public function secondaryEmployee()
    {
        return $this->belongsTo('App\Employee', 'secondary_employee_id', 'id');
    }

    /**
     *  This class belongs to a taEmployee.
     *
     * @return BelongsTo
     */
    public function taEmployee()
    {
        return $this->belongsTo('App\Employee', 'ta_employee_id', 'id');
    }

    /**
     *  This class belongs to a room.
     *
     * @return BelongsTo
     */
    public function room()
    {
        return $this->belongsTo('App\Room', 'room_id', 'id');
    }

    /**
     *  This class belongs to a year.
     *
     * @return BelongsTo
     */
    public function year()
    {
        return $this->belongsTo('App\Year', 'year_id', 'id');
    }

    /**
     *  This class belongs to a status.
     *
     * @return BelongsTo
     */
    public function status()
    {
        return $this->belongsTo('App\ClassStatus', 'class_status_id', 'id');
    }

    /**
     *  This class belongs to a course.
     *
     * @return BelongsTo
     */
    public function course()
    {
        return $this->belongsTo('App\Course', 'course_id', 'id');
    }

    /**
     *  This class was created by a user.
     *
     * @return BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo('App\User', 'user_created_id', 'id');
    }

    /**
     *  This class was updated by a user.
     *
     * @return BelongsTo
     */
    public function updatedBy()
    {
        return $this->belongsTo('App\User', 'user_updated_id', 'id');
    }
}
