<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Webpatser\Uuid\Uuid;
use Laravel\Scout\Searchable;
use Illuminate\Notifications\Notifiable;
use Collective\Html\Eloquent\FormAccessible;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Employee extends PortalBaseModel
{
    use SoftDeletes;
    use FormAccessible;
    use Notifiable;
    use Searchable;

    /**
     * Get the index name for the model.
     *
     * @return string
     */
    public function searchableAs()
    {
        return 'employees';
    }

    protected $touches = ['person'];

    /**
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();

        $array = $this->transform($array);

        $array['display_name'] = $this->person->extendedName();
        $array['email_school'] = $this->person->email_school;
        $array['email_primary'] = $this->person->email_primary;
        $array['email_secondary'] = $this->person->email_secondary;
        $array['url'] = '/employee/'.$this->uuid;

        return $array;
    }

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

    /**
     * Return a formatted dropdown.
     *
     * @param bool $with_preferred
     * @return array
     */
    public static function getDropdown($with_preferred = true)
    {
        return $with_preferred
            ? static::with('person')->get()->pluck('full_name', 'id')
            : static::with('person')->get()->pluck('legal_full_name', 'id');
    }

    /*
    |--------------------------------------------------------------------------
    | ATTRIBUTES
    |--------------------------------------------------------------------------
    */

    /**
     * return the full name of an employee.
     *
     * @return mixed
     */
    public function getFullNameAttribute()
    {
        return $this->person->fullName(true);
    }

    /**
     * return the legal full name of an employee.
     *
     * @return mixed
     */
    public function getLegalFullNameAttribute()
    {
        return $this->person->family_name.', '.$this->person->given_name;
    }

    /**
     * return the full name of an employee.
     *
     * @return mixed
     */
    public function getNameAttribute()
    {
        return '<a href="/employee/'.$this->uuid.'">'.$this->person->fullName().'</a>';
    }

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
     *  This primary_employee has many primaryTeacher.
     *
     * @return HasMany
     */
    public function primaryTeacher()
    {
        return $this->hasMany('App\CourseClass', 'primary_employee_id');
    }

    /**
     *  This secondary_employee has many secondaryTeacher.
     *
     * @return HasMany
     */
    public function secondaryTeacher()
    {
        return $this->hasMany('App\CourseClass', 'secondary_employee_id');
    }

    /**
     *  This ta_employee has many taTeacher.
     *
     * @return HasMany
     */
    public function taTeacher()
    {
        return $this->hasMany('App\CourseClass', 'ta_employee_id');
    }

    /**
     *  This employee belongs to a status.
     *
     * @return BelongsTo
     */
    public function status()
    {
        return $this->belongsTo('App\EmployeeStatus', 'employee_status_id', 'id');
    }

    /**
     *  This employee belongs to a classification.
     *
     * @return BelongsTo
     */
    public function classification()
    {
        return $this->belongsTo('App\EmployeeClassification', 'employee_classification_id', 'id');
    }

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
