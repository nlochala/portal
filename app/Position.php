<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class Position extends Model
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

    /**
     * Add mass-assignment to model.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'name',
        'description',
        'school_id',
        'position_type_id',
        'supervisor_position_id',
        'stipend',
        'user_created_id',
        'user_created_ip',
        'user_updated_id',
        'user_updated_ip',
    ];

    /**
     * Return a formatted dropdown list.
     *
     * @return array
     */
    public static function getDropdown()
    {
        $return_array = [];
        $positions = Position::with('school')->select('id', 'name', 'school_id')->get();
        foreach ($positions->sortBy('name') as $position) {
            $return_array[$position->id] = $position->name.' ('.$position->school->name.')';
        }

        return $return_array;
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

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /**
     * Many positions belongs to many employees.
     *
     * @return BelongsToMany
     */
    public function employees()
    {
        return $this->belongsToMany(
            'App\Employee',
            'employees_positions_pivot',
            'position_id',
            'employee_id'
        )
            ->withTimestamps();
    }

    /**
     *  This position belongs to a supervisor.
     *
     * @return BelongsTo
     */
    public function supervisor()
    {
        return $this->belongsTo('App\Position', 'supervisor_position_id', 'id');
    }

    /**
     * This position belongs to a positionType.
     *
     * @return BelongsTo
     */
    public function type()
    {
        return $this->belongsTo('App\PositionType', 'position_type_id', 'id');
    }

    /**
     * This position belongs to a school.
     *
     * @return BelongsTo
     */
    public function school()
    {
        return $this->belongsTo('App\School', 'school_id', 'id');
    }

    /**
     *  This position was created by a user.
     *
     * @return BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo('App\User', 'user_created_id', 'id');
    }

    /**
     *  This position was updated by a user.
     *
     * @return BelongsTo
     */
    public function updatedBy()
    {
        return $this->belongsTo('App\User', 'user_updated_id', 'id');
    }
}
