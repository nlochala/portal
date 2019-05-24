<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Collective\Html\Eloquent\FormAccessible;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
    use SoftDeletes;
    use FormAccessible;

    /*
    |--------------------------------------------------------------------------
    | SETUP
    |--------------------------------------------------------------------------
    */

    /**
     * The database table (employees) used by the model.
     *
     * @var string
     */
    protected $table = 'employees';

    /**
     * Add mass-assignment to model.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'person_id',
        'start_date',
        'end_date',
        'employee_classification_id',
        'employee_status_id',
        'user_created_id',
        'user_created_ip',
        'user_updated_id',
        'user_updated_ip',
    ];

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

    /** @noinspection PhpMissingParentCallCommonInspection */
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    /**
     * This is a comment.
     *
     * @param self $employee
     *
     * @return array
     */
    public static function getProfileMenu(self $employee)
    {
        $prefix = '/employee/'.$employee->id;

        return [
            'Overview' => $prefix.'/profile',
            'Contact Information' => $prefix.'/profile/contact',
            'Official Documents' => $prefix.'/profile/official_documents',
            'Job Assignment' => $prefix.'/profile/job',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | ATTRIBUTES
    |--------------------------------------------------------------------------
    */

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

        return null;
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

        return null;
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

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */
    /**
     * Many employees belongs to many positions.
     *
     * @return BelongsToMany
     */
    public function positions()
    {
        return $this->belongsToMany(
            'App\Position',
            'employees_positions_pivot',
            'employee_id',
            'position_id'
        )
            ->withTimestamps();
    }

    /**
     *  This employee belongs to a user.
     *
     * @return BelongsTo
     */
    public function createdBy()
    {
        // 5 --> this is the key for the relationship on the table defined on 4
        return $this->belongsTo('App\User', 'user_created_id', 'id');
    }

    /**
     *  This employee belongs to a user.
     *
     * @return BelongsTo
     */
    public function updatedBy()
    {
        // 5 --> this is the key for the relationship on the table defined on 4
        return $this->belongsTo('App\User', 'user_updated_id', 'id');
    }

    /**
     *  This employee belongs to a person.
     *
     * @return BelongsTo
     */
    public function person()
    {
        // 5 --> this is the key for the relationship on the table defined on 4
        return $this->belongsTo('App\Person', 'person_id', 'id');
    }
}
