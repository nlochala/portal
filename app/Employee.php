<?php

namespace App;

use Carbon\Carbon;
use Collective\Html\Eloquent\FormAccessible;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        'person_id',
        'position_id',
        'start_date',
        'end_date',
        'user_created_id',
        'user_created_ip',
        'user_updated_id',
        'user_updated_ip'
    ];

    public static function getProfileMenu(Employee $employee)
    {
        $prefix = '/employee/' . $employee->id;

        return [
            'Overview' => $prefix . '/profile',
            'Contact Information' => $prefix . '/profile/contact',
            'Official Documents' => $prefix . '/profile/official_documents',
            'Job Assignment' => $prefix . '/profile/job',
        ];
    }

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


    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */
    /**
     *  This employee belongs to a user
     *
     * @return BelongsTo
     */
    public function createdBy()
    {
        // 5 --> this is the key for the relationship on the table defined on 4
        return $this->belongsTo('App\User', 'user_created_by', 'id');
    }

    /**
     *  This employee belongs to a user
     *
     * @return BelongsTo
     */
    public function updatedBy()
    {
        // 5 --> this is the key for the relationship on the table defined on 4
        return $this->belongsTo('App\User', 'user_updated_by', 'id');
    }

    /**
     *  This employee belongs to a person
     *
     * @return BelongsTo
     */
    public function person()
    {
        // 5 --> this is the key for the relationship on the table defined on 4
        return $this->belongsTo('App\Person', 'person_id', 'id');
    }
}
