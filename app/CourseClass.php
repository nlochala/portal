<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
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

    public function getStudentsAttribute()
    {
        $students = new Collection();

        $q1 = $this->q1Students()->with('q1Students.person')->get();
        $q2 = $this->q2Students()->with('q2Students.person')->get();
        $q3 = $this->q3Students()->with('q3Students.person')->get();
        $q4 = $this->q4Students()->with('q4Students.person')->get();

        $students->merge([$q1, $q2, $q3, $q4]);
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
