<?php

namespace App;

use Carbon\Carbon;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendanceClass extends PortalBaseModel
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
        'date',
        'student_id',
        'class_id',
        'quarter_id',
        'attendance_type_id',
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
     * isStudent query scope.
     *
     * @param $query
     * @param $student_id
     */
    public function scopeIsStudent($query, $student_id)
    {
        $query->where('student_id', $student_id);
    }

    /**
     * isQuarter query scope.
     *
     * @param $query
     * @param $quarter_id
     */
    public function scopeIsQuarter($query, $quarter_id)
    {
        $query->where('quarter_id', $quarter_id);
    }

    /**
     * Today's Attendance query scope.
     *
     * @param $query
     */
    public function scopeToday($query)
    {
        $query->where('date', '=', now()->format('Y-m-d'));
    }

    /**
     * Date query scope.
     *
     * @param $query
     * @param string $date
     */
    public function scopeDate($query, string $date = 'Y-m-d')
    {
        $query->where('date', '=', $date);
    }

    /**
     * Students who are present query scope.
     *
     * @param $query
     */
    public function scopePresent($query)
    {
        $query->whereHas('type', function ($q) {
            $q->where('is_present', true);
        });
    }

    /**
     * Students who are absent query scope.
     *
     * @param $query
     */
    public function scopeAbsent($query)
    {
        $query->whereHas('type', function ($q) {
            $q->where('is_present', false);
        });
    }

    /**
     * Students who are unexcused tardy.
     *
     * @param $query
     */
    public function scopeUnexcusedTardy($query)
    {
        $query->whereHas('type', function ($q) {
            $q->where('name', 'Tardy - Unexcused');
        });
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /**
     *  This class_attendance belongs to a student.
     *
     * @return BelongsTo
     */
    public function student()
    {
        return $this->belongsTo('App\Student', 'student_id', 'id');
    }

    /**
     *  This class_attendance belongs to a class.
     *
     * @return BelongsTo
     */
    public function class()
    {
        return $this->belongsTo('App\CourseClass', 'class_id', 'id');
    }

    /**
     *  This class_attendance belongs to a type.
     *
     * @return BelongsTo
     */
    public function type()
    {
        return $this->belongsTo('App\AttendanceType', 'attendance_type_id', 'id');
    }

    /**
     *  This class_attendance was created by a user.
     *
     * @return BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo('App\User', 'user_created_id', 'id');
    }

    /**
     *  This class_attendance was updated by a user.
     *
     * @return BelongsTo
     */
    public function updatedBy()
    {
        return $this->belongsTo('App\User', 'user_updated_id', 'id');
    }
}
