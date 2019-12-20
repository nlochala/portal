<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class BehaviorAssessmentAverage extends PortalBaseModel
{
    use SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | SETUP
    |--------------------------------------------------------------------------
    */
    /**
     *  Setup model event hooks
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
        'is_protected',
        'user_created_id',
        'user_created_ip',
        'user_updated_id',
        'user_updated_ip'
    ];

    /*
    |--------------------------------------------------------------------------
    | ATTRIBUTES
    |--------------------------------------------------------------------------
    */
    /**
     * Set created_at to Carbon Object
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
     * Set updated_at to Carbon Object
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
     * isQuarter query scope
     *
     * @param $query
     * @param $quarter_id
     */
    public function scopeIsQuarter($query, $quarter_id)
    {
        $query->where('quarter_id','=',$quarter_id);
    }

    /**
     * isStudent query scope
     *
     * @param $query
     * @param $student_id
     */
    public function scopeIsStudent($query, $student_id)
    {
        $query->where('student_id','=',$student_id);
    }

    /**
     * isClass query scope
     *
     * @param $query
     * @param $class_id
     */
    public function scopeIsClass($query, $class_id)
    {
        $query->where('class_id','=',$class_id);
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */
    /**
     * This average has a Student
     *
     * @return HasOne
     */
    public function student()
    {
        // 6 --> this is the key for the relationship on the table defined on 4
        return $this->hasOne('App\Student','id','student_id');
    }

    /**
     * This average has a quarter
     *
     * @return HasOne
     */
    public function quarter()
    {
        // 6 --> this is the key for the relationship on the table defined on 4
        return $this->hasOne('App\Quarter','id','quarter_id');
    }

    /**
     * This average has a class
     *
     * @return HasOne
     */
    public function class()
    {
        // 6 --> this is the key for the relationship on the table defined on 4
        return $this->hasOne('App\CourseClass','id','class_id');
    }

    /**
     *  This average was created by a user
     *
     * @return BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo('App\User','user_created_id','id');
    }

    /**
     *  This average was updated by a user
     *
     * @return BelongsTo
     */
    public function updatedBy()
    {
        return $this->belongsTo('App\User','user_updated_id','id');
    }
}
