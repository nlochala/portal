<?php

namespace App;

use Carbon\Carbon;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Quarter extends PortalBaseModel
{
    use SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | SETUP
    |--------------------------------------------------------------------------
    */

    public static $name = [
        1 => 'Q1',
        2 => 'Q2',
        3 => 'Q3',
        4 => 'Q4',
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

        // Order by name ASC
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('name', 'asc');
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
        'name',
        'year_id',
        'start_date',
        'end_date',
        'instructional_days',
        'is_protected',
        'user_created_id',
        'user_created_ip',
        'user_updated_id',
        'user_updated_ip',
    ];

    /**
     * Return the text name of the quarter based on the ID.
     *
     * @param $id
     * @return mixed
     */
    public static function getName($id)
    {
        return static::$name[$id];
    }

    /**
     * Return a formatted dropdown.
     *
     * @param null $scope
     * @param null $year_id
     * @return array
     */
    public static function getDropdown($scope = null, $year_id = null)
    {
        if ($scope) {
            return static::$scope()->get()->pluck('name', 'id')->toArray();
        }

        if ($year_id) {
            return static::isYear($year_id)->get()->pluck('name', 'id')->toArray();
        }

        return static::all()->pluck('name', 'id')->toArray();
    }

    /**
     * Return the current quarter.
     *
     * @return mixed
     */
    public static function now()
    {
        $quarters = static::current()->get();
        $now = Carbon::now();
        for ($i = 0; $i < $quarters->count(); $i++) {
            $start_date = Carbon::parse($quarters[$i]->start_date);
            $end_date = Carbon::parse($quarters[$i]->end_date);

            // Before school starts
            if ($quarters[$i]->name === 'Q1' && $now->lessThan($start_date)) {
                return $quarters[$i];
            }

            // In between Quarters
            if ($quarters[$i]->name !== 'Q4') {
                if ($now->greaterThan($end_date) && $now->lessThan(Carbon::parse($quarters[$i + 1]->start_date))) {
                    return $quarters[$i];
                }
            }

            if ($quarters[$i]->start_date === $now->format('Y-m-d') || $quarters[$i]->end_date === $now->format('Y-m-d')) {
                return $quarters[$i];
            }

            if ($now->isBetween($start_date, $end_date)) {
                return $quarters[$i];
            }
        }

        return $quarters->last();
    }

    /**
     * Return the current quarter.
     * If allow_null is set, it will return false if the date is not within the dates of a quarter.
     *
     * @param string $date
     * @param bool $allow_null
     * @param Year $year
     * @return mixed
     */
    public static function getQuarter(string $date = 'Y-m-d', $allow_null = false, Year $year = null)
    {
        if (empty($year)) {
            $quarters = static::current()->get();
        } else {
            $quarters = $year->quarters;
        }

        $now = Carbon::parse($date);
        foreach ($quarters as $quarter) {
            $start_date = Carbon::parse($quarter->start_date);
            $end_date = Carbon::parse($quarter->end_date);

            // Before school starts
            if ($quarter->name === 'Q1' && $now->lessThan($start_date)) {
                return $quarter;
            }

            if ($now->isBetween($start_date, $end_date)) {
                return $quarter;
            }
        }

        return $allow_null ? null : $quarters->last();
    }

    /**
     * Return the relationship.
     *
     * @return string
     */
    public function getClassRelationship()
    {
        switch ($this->name) {
            case 'Q1':
                return 'q1Students';
                break;
            case 'Q2':
                return 'q2Students';
                break;
            case 'Q3':
                return 'q3Students';
                break;
            case 'Q4':
                return 'q4Students';
                break;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | ATTRIBUTES
    |--------------------------------------------------------------------------
    */

    /**
     * Return formatted start date.
     *
     * @param $value
     *
     * @return mixed
     */
    public function getStartDateAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }

    /**
     * Return formatted end date.
     *
     * @param $value
     *
     * @return mixed
     */
    public function getEndDateAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
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
     * current query scope.
     *
     * @param $query
     */
    public function scopeCurrent($query)
    {
        $query->where('year_id', '=', env('SCHOOL_YEAR_ID'));
    }

    /**
     * isYear query scope.
     *
     * @param $query
     * @param $year_id
     */
    public function scopeIsYear($query, $year_id)
    {
        $query->where('year_id', $year_id);
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /**
     *  This quarter has many holidays.
     *
     * @return HasMany
     */
    public function holidays()
    {
        return $this->hasMany('App\Holiday', 'quarter_id');
    }

    /**
     *  This quarter has many days.
     *
     * @return HasMany
     */
    public function days()
    {
        return $this->hasMany('App\Day', 'quarter_id');
    }

    /**
     *  This quarter has many gradeAverages.
     *
     * @return HasMany
     */
    public function gradeAverages()
    {
        return $this->hasMany('App\GradeAverage', 'quarter_id');
    }

    /**
     *  This quarter has many gradeQuarterAverages.
     *
     * @return HasMany
     */
    public function gradeQuarterAverages()
    {
        return $this->hasMany('App\GradeQuarterAverage', 'quarter_id');
    }

    /**
     *  This quarter belongs to a year.
     *
     * @return BelongsTo
     */
    public function year()
    {
        return $this->belongsTo('App\Year', 'year_id', 'id');
    }

    /**
     *  This quarter was created by a user.
     *
     * @return BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo('App\User', 'user_created_id', 'id');
    }

    /**
     *  This quarter was updated by a user.
     *
     * @return BelongsTo
     */
    public function updatedBy()
    {
        return $this->belongsTo('App\User', 'user_updated_id', 'id');
    }
}
