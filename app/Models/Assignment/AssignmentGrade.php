<?php

namespace App;

use Carbon\Carbon;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssignmentGrade extends PortalBaseModel
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

    protected $casts = [
        'is_protected' => 'bool',
        'is_excused' => 'bool',
    ];

    /**
     * Add mass-assignment to model.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'assignment_id',
        'student_id',
        'points_earned',
        'date_completed',
        'notes',
        'is_excused',
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
     * Get carbon object and format.
     *
     * @param $value
     *
     * @return mixed
     */
    public function getDateCompletedAttribute($value)
    {
        if (empty($value)) {
            return '--';
        }

        return Carbon::parse($value)->format('Y-m-d');
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
     * Assignment query scope.
     *
     * @param $query
     * @param $assignment_id
     */
    public function scopeIsAssignment($query, $assignment_id)
    {
        $query->where('assignment_id', '=', $assignment_id);
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

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /**
     * This grade has a Assignment.
     *
     * @return HasOne
     */
    public function assignment()
    {
        // 6 --> this is the key for the relationship on the table defined on 4
        return $this->hasOne('App\Assignment', 'id', 'assignment_id');
    }

    /**
     * This grade has a Student.
     *
     * @return HasOne
     */
    public function student()
    {
        // 6 --> this is the key for the relationship on the table defined on 4
        return $this->hasOne('App\Student', 'id', 'student_id');
    }

    /**
     *  This grade was created by a user.
     *
     * @return BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo('App\User', 'user_created_id', 'id');
    }

    /**
     *  This grade was updated by a user.
     *
     * @return BelongsTo
     */
    public function updatedBy()
    {
        return $this->belongsTo('App\User', 'user_updated_id', 'id');
    }
}
