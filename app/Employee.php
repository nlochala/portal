<?php

namespace App;

use Carbon\Carbon;
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
        'position_id',
        'start_date',
        'end_date',
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
     *  This employee belongs to a user.
     *
     * @return BelongsTo
     */
    public function createdBy()
    {
        // 5 --> this is the key for the relationship on the table defined on 4
        return $this->belongsTo('App\User', 'user_created_by', 'id');
    }

    /**
     *  This employee belongs to a user.
     *
     * @return BelongsTo
     */
    public function updatedBy()
    {
        // 5 --> this is the key for the relationship on the table defined on 4
        return $this->belongsTo('App\User', 'user_updated_by', 'id');
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
