<?php

namespace App;

use Carbon\Carbon;
use Webpatser\Uuid\Uuid;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Guardian extends PortalBaseModel
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
        return 'guardians';
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
        $array['url'] = '/guardian/'.$this->uuid;

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

    protected $casts = ['is_protected' => 'bool', 'is_imported' => 'bool'];

    /**
     * Add mass-assignment to model.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'person_id',
        'family_id',
        'guardian_type_id',
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
     * return the full name of a guardian.
     *
     * @return mixed
     */
    public function getFullNameAttribute()
    {
        $first_name = $this->person->preferred_name
            ?: $this->person->given_name;

        return $this->person->family_name.', '.$first_name;
    }

    /**
     * return the full name of an employee.
     *
     * @return mixed
     */
    public function getNameAttribute()
    {
        return '<a href="/guardian/'.$this->uuid.'">'.$this->person->fullName().'</a>';
    }

    /**
     * return the full name of a guardian.
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

    /**
     * isImported query scope
     *
     * @param $query
     * @param $imported
     */
    public function scopeIsImported($query, $imported)
    {
        $query->where('is_imported',$imported);
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /**
     *  This guardian belongs to a family.
     *
     * @return BelongsTo
     */
    public function family()
    {
        return $this->belongsTo('App\Family', 'family_id', 'id');
    }

    /**
     *  This guardian belongs to a person.
     *
     * @return BelongsTo
     */
    public function person()
    {
        return $this->belongsTo('App\Person', 'person_id', 'id');
    }

    /**
     *  This guardian belongs to a status.
     *
     * @return BelongsTo
     */
    public function type()
    {
        return $this->belongsTo('App\GuardianType', 'guardian_type_id', 'id');
    }

    /**
     *  This guardian was created by a user.
     *
     * @return BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo('App\User', 'user_created_id', 'id');
    }

    /**
     *  This guardian was updated by a user.
     *
     * @return BelongsTo
     */
    public function updatedBy()
    {
        return $this->belongsTo('App\User', 'user_updated_id', 'id');
    }
}
