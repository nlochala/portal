<?php

namespace App;

use Carbon\Carbon;
use Webpatser\Uuid\Uuid;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends PortalBaseModel
{
    use SoftDeletes;
    use Searchable;

    /**
     * Get the index name for the model.
     *
     * @return string
     */
    public function searchableAs()
    {
        return 'students';
    }

    protected $touches = ['person', 'gradeLevel'];

    /**
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();

        $array = $this->transform($array);

        $array['status'] = $this->status->name;
        $array['display_name'] = $this->person->extendedName();
        $array['grade_level'] = $this->gradeLevel->name;
        $array['email_school'] = $this->person->email_school;
        $array['email_primary'] = $this->person->email_primary;
        $array['email_secondary'] = $this->person->email_secondary;
        $array['url'] = '/student/'.$this->uuid;

        return $array;
    }

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
        'is_protected' => 'bool',
        'is_imported' => 'bool',
    ];

    /**
     * Add mass-assignment to model.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'person_id',
        'family_id',
        'student_status_id',
        'grade_level_id',
        'start_date',
        'end_date',
        'is_protected',
        'username',
        'password',
        'user_created_id',
        'user_created_ip',
        'user_updated_id',
        'user_updated_ip',
    ];

    /**
     * Return the wifi username.
     *
     * @return mixed|string
     */
    public function getWifiUsername()
    {
        return empty($this->username)
            ? '---'
            : str_replace('@tlcdg.com', '', $this->username);
    }

    /*
    |--------------------------------------------------------------------------
    | ATTRIBUTES
    |--------------------------------------------------------------------------
    */

    /**
     * get student email attribute.
     *
     * @param $value
     *
     * @return mixed
     */
    public function getEmailAttribute($value)
    {
        return $this->username
            ? '<a href="mailto:'.$this->username.'">'.$this->username.'</a>'
            : '---';
    }

    /**
     * Get this students classes.
     *
     * @return mixed
     */
    public function getClassesAttribute()
    {
        return $this->enrollments->classes;
    }

    /**
     * return the full name of an employee.
     *
     * @return mixed
     */
    public function getNameAttribute()
    {
        return '<a href="/student/'.$this->uuid.'">'.$this->person->fullName().'</a>';
    }

    /**
     * return the full name of a student.
     *
     * @return mixed
     */
    public function getLegalFullNameAttribute()
    {
        return $this->person->family_name.', '.$this->person->given_name;
    }

    /**
     * return the full name of a student.
     *
     * @return mixed
     */
    public function getFullNameAttribute()
    {
        $first_name = $this->person->preferred_name
            ?: $this->person->given_name;

        return $this->person->family_name.', '.$first_name;
    }

    /**
     * Return the formal and href name of the student.
     *
     * @return string
     */
    public function getFormalNameAttribute()
    {
        $given_name = $this->person->given_name.' '.$this->person->name_in_chinese;
        if ($this->person->given_name !== $this->person->preferred_name) {
            $given_name .= ' ('.$this->person->preferred_name.')';
        }

        return '<a href="/student/'.$this->uuid.'">'.$this->person->family_name.', '.$given_name.'</a>';
    }

    /**
     * return start_date as carbon object.
     *
     * @param $value
     *
     * @return mixed
     */
    public function getStartDateAttribute($value)
    {
        if ($value) {
            return Carbon::parse($value)->format('Y-m-d');
        }
    }

    /**
     * return end_date as carbon object.
     *
     * @param $value
     *
     * @return mixed
     */
    public function getEndDateAttribute($value)
    {
        if ($value) {
            return Carbon::parse($value)->format('Y-m-d');
        }
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
     * Family query scope.
     *
     * @param $query
     */
    public function scopeHasFamily($query)
    {
        $query->whereNotNull('family_id');
    }

    /**
     * Return the perspective students.
     *
     * @param $query
     */
    public function scopePerspective($query)
    {
        $query->where('student_status_id', '=', 1);
    }

    /**
     * Return the incoming students.
     *
     * @param $query
     */
    public function scopeIncoming($query)
    {
        $query->where('student_status_id', '=', 2);
    }

    /**
     * Return the current students.
     *
     * @param $query
     */
    public function scopeCurrent($query)
    {
        $query->where('student_status_id', '=', 3);
    }

    /**
     * Return the graduated students.
     *
     * @param $query
     */
    public function scopeGraduated($query)
    {
        $query->where('student_status_id', '=', 4);
    }

    /**
     * Return the former students.
     *
     * @param $query
     */
    public function scopeFormer($query)
    {
        $query->where('student_status_id', '=', 5);
    }

    /**
     * Grade query scope.
     *
     * @param $query
     * @param $grade_short_name
     */
    public function scopeGrade($query, $grade_short_name)
    {
        $query->whereHas('gradeLevel', static function ($q) use ($grade_short_name) {
            $q->where('short_name', '=', $grade_short_name);
        });
    }

    /**
     * Student has been imported into AD query scope.
     *
     * @param $query
     * @param bool $parameter
     */
    public function scopeIsImported($query, bool $parameter)
    {
        $query->where('is_imported', $parameter);
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /**
     *  This student has many behaviorGrade.
     *
     * @return HasMany
     */
    public function behaviorGrades()
    {
        return $this->hasMany('App\GradeBehaviorQuarter', 'student_id');
    }

    /**
     *  This student has many gradeQuarterAverages.
     *
     * @return HasMany
     */
    public function gradeQuarterAverages()
    {
        return $this->hasMany('App\GradeQuarterAverage', 'student_id');
    }

    /**
     *  This student has many gradeAverages.
     *
     * @return HasMany
     */
    public function gradeAverages()
    {
        return $this->hasMany('App\GradeAverage', 'student_id');
    }

    /**
     *  This student has many dailyAttendance.
     *
     * @return HasMany
     */
    public function todaysDailyAttendance()
    {
        return $this->hasMany('App\AttendanceDay', 'student_id')
            ->where('date', '=', now()->format('Y-m-d'));
    }

    /**
     *  This student has many dailyAttendance.
     *
     * @return HasMany
     */
    public function todaysClassAttendance()
    {
        return $this->hasMany('App\AttendanceClass', 'student_id')
            ->where('date', '=', now()->format('Y-m-d'));
    }

    /**
     *  This student has many dailyAttendance.
     *
     * @return HasMany
     */
    public function dailyAttendance()
    {
        return $this->hasMany('App\AttendanceDay', 'student_id');
    }

    /**
     *  This student has many dailyAttendance.
     *
     * @return HasMany
     */
    public function dailyClassAttendance()
    {
        return $this->hasMany('App\AttendanceClass', 'student_id');
    }

    /**
     *  This student belongs to a family.
     *
     * @return BelongsTo
     */
    public function family()
    {
        return $this->belongsTo('App\Family', 'family_id', 'id');
    }

    /**
     *  This student belongs to a person.
     *
     * @return BelongsTo
     */
    public function person()
    {
        return $this->belongsTo('App\Person', 'person_id', 'id');
    }

    /**
     *  This student belongs to a gradeLevel.
     *
     * @return BelongsTo
     */
    public function gradeLevel()
    {
        return $this->belongsTo('App\GradeLevel', 'grade_level_id', 'id');
    }

    /**
     *  This student belongs to a status.
     *
     * @return BelongsTo
     */
    public function status()
    {
        return $this->belongsTo('App\StudentStatus', 'student_status_id', 'id');
    }

    /**
     *  This student was created by a user.
     *
     * @return BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo('App\User', 'user_created_id', 'id');
    }

    /**
     *  This student was updated by a user.
     *
     * @return BelongsTo
     */
    public function updatedBy()
    {
        return $this->belongsTo('App\User', 'user_updated_id', 'id');
    }
}
