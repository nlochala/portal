<?php

namespace App;

use Carbon\Carbon;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportCardPercentage extends PortalBaseModel
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
        'grade_behavior_quarter_id',
        'days_absent',
        'days_present',
        'days_tardy',
        'comment',
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

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /**
     * This report_card has a Quarter.
     *
     * @return HasOne
     */
    public function quarter()
    {
        // 6 --> this is the key for the relationship on the table defined on 4
        return $this->hasOne('App\Quarter', 'id', 'quarter_id');
    }

    /**
     *  This report_card_percentage has many classGrades.
     *
     * @return HasMany
     */
    public function classGrades()
    {
        return $this->hasMany('App\ReportCardPercentageClass', 'report_card_percentage_id');
    }

    /**
     * This report_card has a GradeBehaviorQuarter.
     *
     * @return HasOne
     */
    public function behaviorGrade()
    {
        // 6 --> this is the key for the relationship on the table defined on 4
        return $this->hasOne('App\GradeBehaviorQuarter', 'id', 'grade_behavior_quarter_id');
    }

    /**
     * This report_card has a Student.
     *
     * @return HasOne
     */
    public function student()
    {
        // 6 --> this is the key for the relationship on the table defined on 4
        return $this->hasOne('App\Student', 'id', 'student_id');
    }

    /**
     *  This report_card was created by a user.
     *
     * @return BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo('App\User', 'user_created_id', 'id');
    }

    /**
     *  This report_card was updated by a user.
     *
     * @return BelongsTo
     */
    public function updatedBy()
    {
        return $this->belongsTo('App\User', 'user_updated_id', 'id');
    }
}
