<?php

namespace App;

use Carbon\Carbon;
use Webpatser\Uuid\Uuid;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends PortalBaseModel
{
    use SoftDeletes;
    use Searchable;

    /**
     * Get the index name for the model.
     *
     * @return string
     */
    public function searchableAs()
    {
        return 'students';
    }

    protected $touches = ['person', 'gradeLevel'];

    /**
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();

        $array = $this->transform($array);

        $array['display_name'] = $this->person->extendedName();
        $array['grade_level'] = $this->gradeLevel->name;
        $array['email_school'] = $this->person->email_school;
        $array['email_primary'] = $this->person->email_primary;
        $array['email_secondary'] = $this->person->email_secondary;
        $array['url'] = '/student/'.$this->uuid;

        return $array;
    }

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
        'person_id',
        'family_id',
        'student_status_id',
        'grade_level_id',
        'start_date',
        'end_date',
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
     * return the full name of an employee.
     *
     * @return mixed
     */
    public function getNameAttribute()
    {
        return '<a href="/student/'.$this->uuid.'">'.$this->person->fullName().'</a>';
    }

    /**
     * return the full name of a student.
     *
     * @param $value
     *
     * @return mixed
     */
    public function getLegalFullNameAttribute()
    {
        return $this->person->family_name.', '.$this->person->given_name;
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

    /**
     * Family query scope.
     *
     * @param $query
     */
    public function scopeHasFamily($query)
    {
        $query->whereNotNull('family_id');
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /**
     *  This student belongs to a family.
     *
     * @return BelongsTo
     */
    public function family()
    {
        return $this->belongsTo('App\Family', 'family_id', 'id');
    }

    /**
     *  This student belongs to a person.
     *
     * @return BelongsTo
     */
    public function person()
    {
        return $this->belongsTo('App\Person', 'person_id', 'id');
    }

    /**
     *  This student belongs to a gradeLevel.
     *
     * @return BelongsTo
     */
    public function gradeLevel()
    {
        return $this->belongsTo('App\GradeLevel', 'grade_level_id', 'id');
    }

    /**
     *  This student belongs to a status.
     *
     * @return BelongsTo
     */
    public function status()
    {
        return $this->belongsTo('App\StudentStatus', 'student_status_id', 'id');
    }

    /**
     *  This student was created by a user.
     *
     * @return BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo('App\User', 'user_created_id', 'id');
    }

    /**
     *  This student was updated by a user.
     *
     * @return BelongsTo
     */
    public function updatedBy()
    {
        return $this->belongsTo('App\User', 'user_updated_id', 'id');
    }
}
