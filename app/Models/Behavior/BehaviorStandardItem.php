<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class BehaviorStandardItem extends PortalBaseModel
{
    use SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | SETUP
    |--------------------------------------------------------------------------
    */
    /**
     *  Setup model event hooks
     */
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });

        // Order by name DESC
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('value', 'desc');
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

    protected $casts =
        [
            'is_protected' => 'bool',
        ];

    /**
     * Add mass-assignment to model.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'behavior_standard_id',
        'name',
        'description',
        'value',
        'is_protected',
        'user_created_id',
        'user_created_ip',
        'user_updated_id',
        'user_updated_ip'
    ];

    /**
     * Return a formatted dropdown.
     *
     * @param null $scope
     * @param null $scope_parameter
     * @return array
     */
    public static function getDropdown($scope = null, $scope_parameter = null)
    {
        if ($scope) {
            return static::$scope($scope_parameter)->get()->pluck('extendedName', 'id')->toArray();
        }

        return static::all()->pluck('extendedName', 'id')->toArray();
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

    /**
     * Return an extended name
     * S - The student consistently....
     *
     * @return string
     */
    public function getExtendedNameAttribute()
    {
        return substr($this->name, 0,1).' - '.$this->description;
    }


    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    /**
     * isStandard query scope
     *
     * @param $query
     * @param $standard_id
     */
    public function scopeIsStandard($query, $standard_id)
    {
        $query->where('behavior_standard_id','=',$standard_id);
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */
    /**
     * This item has a BehaviorStandard
     *
     * @return HasOne
     */
    public function standard()
    {
        // 6 --> this is the key for the relationship on the table defined on 4
        return $this->hasOne('App\BehaviorStandard','id','behavior_standard_id');
    }

    /**
     *  This behavior_standard_item was created by a user
     *
     * @return BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo('App\User','user_created_id','id');
    }

    /**
     *  This behavior_standard_item was updated by a user
     *
     * @return BelongsTo
     */
    public function updatedBy()
    {
        return $this->belongsTo('App\User','user_updated_id','id');
    }
}
