<?php

namespace App;

use Carbon\Carbon;
use App\Helpers\Helpers;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendanceDay extends PortalBaseModel
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
            $model->uuid = (string)Uuid::generate(4);
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
        'quarter_id',
        'attendance_type_id',
        'is_protected',
        'user_created_id',
        'user_created_ip',
        'user_updated_id',
        'user_updated_ip',
    ];

    /**
     * @param array $dates_array
     * @param string $attendance_type
     * @return array
     */
    public static function getStudentCount($attendance_type = 'absent or present', array $dates_array = null)
    {
        $dates_array = $dates_array ?: Helpers::getPreviousWorkingDays(now()->format('Y-m-d'));

        $count_array = [];
        foreach ($dates_array as $date) {
            $count_array[] = static::date($date)->$attendance_type()->count();
        }

        return $count_array;
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
     * isYear query scope
     *
     * @param $query
     * @param $year_id
     */
    public function scopeIsYear($query, $year_id)
    {
        $query->whereHas('quarter', function ($q) use ($year_id) {
            $q->where('year_id', $year_id);
        });
    }

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
     * Today's Attendance query scope.
     *
     * @param $query
     */
    public function scopeToday($query)
    {
        $query->where('date', '=', now()->format('Y-m-d'));
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

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /**
     *  This attendance belongs to a quarter
     *
     * @return BelongsTo
     */
    public function quarter()
    {
        return $this->belongsTo('App\Quarter', 'quarter_id', 'id');
    }


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
     *  This class_attendance belongs to a type.
     *
     * @return BelongsTo
     */
    public function type()
    {
        return $this->belongsTo('App\AttendanceType', 'attendance_type_id', 'id');
    }

    /**
     *  This daily attendance was created by a user.
     *
     * @return BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo('App\User', 'user_created_id', 'id');
    }

    /**
     *  This daily attendance was updated by a user.
     *
     * @return BelongsTo
     */
    public function updatedBy()
    {
        return $this->belongsTo('App\User', 'user_updated_id', 'id');
    }
}
