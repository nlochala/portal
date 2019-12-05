<?php

namespace App;

use Carbon\Carbon;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Assignment extends PortalBaseModel
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
        'can_display' => 'bool',
        'is_test' => 'bool',
    ];

    /**
     * Add mass-assignment to model.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'assignment_type_id',
        'name',
        'description',
        'date_assigned',
        'date_due',
        'max_points',
        'can_display',
        'is_test',
        'quarter_id',
        'class_id',
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

    /**
     * Set updated_at to Carbon Object.
     *
     * @param $value
     *
     * @return mixed
     */
    public function getDateDueAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }

    /**
     * Set updated_at to Carbon Object.
     *
     * @param $value
     *
     * @return mixed
     */
    public function getDateAssignedAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /**
     * Class query scope.
     *
     * @param $query
     * @param $class_id
     */
    public function scopeCourseClass($query, $class_id)
    {
        $query->where('class_id', '=', $class_id);
    }

    /**
     * Quarter query scope.
     *
     * @param $query
     * @param $quarter_id
     */
    public function scopeQuarter($query, $quarter_id)
    {
        $query->where('quarter_id', '=', $quarter_id);
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /**
     *  This assignment has many grades.
     *
     * @return HasMany
     */
    public function grades()
    {
        return $this->hasMany('App\AssignmentGrade', 'assignment_id');
    }

    /**
     * This assignment has a CourseClass.
     *
     * @return HasOne
     */
    public function class()
    {
        // 6 --> this is the key for the relationship on the table defined on 4
        return $this->hasOne('App\CourseClass', 'id', 'class_id');
    }

    /**
     * This assignment has a Quarter.
     *
     * @return HasOne
     */
    public function quarter()
    {
        // 6 --> this is the key for the relationship on the table defined on 4
        return $this->hasOne('App\Quarter', 'id', 'quarter_id');
    }

    /**
     * This assignment has a AssignmentType.
     *
     * @return HasOne
     */
    public function type()
    {
        // 6 --> this is the key for the relationship on the table defined on 4
        return $this->hasOne('App\AssignmentType', 'id', 'assignment_type_id');
    }

    /**
     *  This assignments was created by a user.
     *
     * @return BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo('App\User', 'user_created_id', 'id');
    }

    /**
     *  This assignments was updated by a user.
     *
     * @return BelongsTo
     */
    public function updatedBy()
    {
        return $this->belongsTo('App\User', 'user_updated_id', 'id');
    }
}
