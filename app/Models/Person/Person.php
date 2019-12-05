<?php

namespace App;

use Carbon\Carbon;
use App\Helpers\Helpers;
use Webpatser\Uuid\Uuid;
use Collective\Html\Eloquent\FormAccessible;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Person extends PortalBaseModel
{
    use SoftDeletes;
    use FormAccessible;

    /**
     * The database table (persons) used by the model.
     *
     * @var string
     */
    protected $table = 'persons';

    /**
     *  Setup model event hooks.
     */
    public static function boot()
    {
        parent::boot();
        self::creating(/**
         * @param $model
         */ function ($model) {
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
     * This populates the dropdown for title.
     *
     * @var array
     */
    public static $titleDropdown = [
        'Mr.',
        'Mrs.',
        'Miss.',
        'Prof.',
        'Sir.',
        'Dr.',
    ];

    /**
     * This populates the dropdown for gender.
     *
     * @var array
     */
    public static $genderRadio = [
        'Male',
        'Female',
    ];

    /**
     * Return the value for a given key in the title array.
     *
     * @param int $title
     *
     * @return mixed
     */
    public static function getTitle(Int $title)
    {
        return static::$titleDropdown[$title];
    }

    /**
     * Return the resolved gender.
     *
     * @param $gender
     *
     * @return mixed
     */
    public static function getGender($gender)
    {
        return static::$genderRadio[$gender];
    }

    /**
     * This is the displayed name used when indexing the persons for searching.
     *
     * @return string
     */
    public function extendedName()
    {
        $name = '';
        ! $this->title ?: $name .= "$this->title ";
        $name .= "$this->family_name, $this->given_name";
        ! $this->name_in_chinese ?: $name .= " $this->name_in_chinese";

        $name .= " ($this->preferred_name)";

        return $name;
    }

    /**
     * Return the properly formatted full name.
     *
     * @param bool $last_name_first
     *
     * @return string
     */
    public function fullName($last_name_first = false)
    {
        $family_name = $this->family_name ? $this->family_name : $this->user->family_name;

        return $last_name_first
            ? $family_name.', '.$this->preferredName()
            : $this->preferredName().' '.$family_name;
    }

    /**
     * Display the preferredName of the person.
     *
     * @return mixed
     */
    public function preferredName()
    {
        $name = $this->preferred_name ? $this->preferred_name : $this->given_name;

        if (! $this->preferred_name && ! $this->given_name) {
            $name = $this->user->given_name;
        }

        return $name;
    }

    /*
    |--------------------------------------------------------------------------
    | SETUP
    |--------------------------------------------------------------------------
    */

    /**
     * Add mass-assignment to model.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'title',
        'given_name',
        'family_name',
        'preferred_name',
        'name_in_chinese',
        'gender',
        'dob',
        'email_primary',
        'email_secondary',
        'email_school',
        'image_file_id',
        'person_type_id',
        'country_of_birth_id',
        'language_primary_id',
        'language_secondary_id',
        'language_tertiary_id',
        'ethnicity_id',
        'user_created_id',
        'user_created_ip',
        'user_updated_id',
        'user_updated_ip',
    ];

    /**
     * Display the profile image.
     *
     * @param int $width
     * @return string
     */
    public function profileImage($width = 200)
    {
        $image = $this->image;

        if (! $image) {
            $image = $this->gender
                ? File::where('name', 'profile-'.strtolower($this->gender))->first()
                : File::find(8);
        }

        return '<img dusk="profile-image" width="'.$width.'" 
            class="img-fluid options-item rounded border border-2x border-dark" src="'.$image->renderImage().'" alt="">';
    }

    /**
     * Return formatted email.
     *
     * @return string
     */
    public function emails()
    {
        $emails = '';
        $email = $this->email_primary ? $this->email_primary : '--';
        $emails .= "<strong>Primary Email:</strong> <a href='mailto:$email'>
            $email</a>";

        ! $this->email_secondary ?: $emails .= "<br /><strong>Secondary Email:</strong> 
            <a href='mailto:$this->email_secondary'>$this->email_secondary</a>";
        ! $this->email_school ?: $emails .= "<br /><strong>School Email:</strong> 
            <a href='mailto:$this->email_school'>$this->email_school</a>";

        return $emails;
    }

    /**
     * Return a list of phone numbers for a given person.
     *
     * @return string
     */
    public function phoneNumbers()
    {
        $numbers = null;
        for ($i = 0; $i < $this->phones->count(); $i++) {
            if ($i === 0) {
                $numbers = $this->phones[$i]->formattedNumber();
            } else {
                $numbers .= '<br />'.$this->phones[$i]->formattedNumber();
            }
        }

        return $numbers;
    }

    /*
    |--------------------------------------------------------------------------
    | ATTRIBUTES
    |--------------------------------------------------------------------------
    */

    /**
     * Get Dob to Carbon Object.
     *
     * @param $value
     *
     * @return mixed
     */
    public function getDobAttribute($value)
    {
        return Carbon::parse($value);
    }

    /**
     * Get age.
     *
     * @return mixed
     */
    public function getAgeAttribute()
    {
        $dob = Carbon::parse($this->dob);

        return Helpers::getAge($dob);
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

    /**
     * Get the employee's Dob for forms.
     *
     * @param string $value
     *
     * @return string
     */
    public function formDobAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }

    /**
     * Get the employee's Title for forms.
     *
     * @param string $value
     *
     * @return string
     */
    public function formTitleAttribute($value)
    {
        return array_search($value, static::$titleDropdown);
    }

    /**
     * Get the person's Gender for forms.
     *
     * @param string $value
     *
     * @return string
     */
    public function formGenderAttribute($value)
    {
        return array_search($value, static::$genderRadio);
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
     *  This person has many officialDocuments.
     *
     * @return HasMany
     */
    public function officialDocuments()
    {
        return $this->hasMany('App\OfficialDocument', 'person_id');
    }

    /**
     *  This person has many idCards.
     *
     * @return HasMany
     */
    public function idCards()
    {
        return $this->hasMany('App\IdCard', 'person_id');
    }

    /**
     *  This person has many passports.
     *
     * @return HasMany
     */
    public function passports()
    {
        return $this->hasMany('App\Passport', 'person_id');
    }

    /**
     *  This person belongs to a user.
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'id', 'person_id');
    }

    /**
     *  This person has many addresses.
     *
     * @return HasMany
     */
    public function addresses()
    {
        return $this->hasMany('App\Address', 'person_id');
    }

    /**
     *  This person has many phone numbers.
     *
     * @return HasMany
     */
    public function phones()
    {
        return $this->hasMany('App\Phone', 'person_id');
    }

    /**
     *  This person belongs to a employee.
     *
     * @return BelongsTo
     */
    public function employee()
    {
        return $this->belongsTo('App\Employee', 'id', 'person_id');
    }

    /**
     *  This person belongs to a student.
     *
     * @return BelongsTo
     */
    public function student()
    {
        return $this->belongsTo('App\Student', 'id', 'person_id');
    }

    /**
     *  This person belongs to a guardian.
     *
     * @return BelongsTo
     */
    public function guardian()
    {
        return $this->belongsTo('App\Guardian', 'id', 'person_id');
    }

    /**
     * This person has a File.
     *
     * @return HasOne
     */
    public function image()
    {
        // 6 --> this is the key for the relationship on the table defined on 4
        return $this->hasOne('App\File', 'id', 'image_file_id');
    }

    /**
     *  This user belongs to a user.
     *
     * @return BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo('App\User', 'user_created_id', 'id');
    }

    /**
     *  This user belongs to a user.
     *
     * @return BelongsTo
     */
    public function updatedBy()
    {
        return $this->belongsTo('App\User', 'user_updated_id', 'id');
    }

    /**
     *  This person belongs to a nationality.
     *
     * @return BelongsTo
     */
    public function nationality()
    {
        return $this->belongsTo('App\Country', 'country_of_birth_id', 'id');
    }

    /**
     *  This person belongs to a language.
     *
     * @return BelongsTo
     */
    public function primaryLanguage()
    {
        return $this->belongsTo('App\Language', 'language_primary_id', 'id');
    }

    /**
     *  This person belongs to a language.
     *
     * @return BelongsTo
     */
    public function secondaryLanguage()
    {
        return $this->belongsTo('App\Language', 'language_secondary_id', 'id');
    }

    /**
     *  This person belongs to a language.
     *
     * @return BelongsTo
     */
    public function tertiaryLanguage()
    {
        return $this->belongsTo('App\Language', 'language_tertiary_id', 'id');
    }

    /**
     *  This person belongs to a ethnicity.
     *
     * @return BelongsTo
     */
    public function ethnicity()
    {
        return $this->belongsTo('App\Ethnicity', 'ethnicity_id', 'id');
    }
}
