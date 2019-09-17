<?php

namespace App;

use Carbon\Carbon;
use Webpatser\Uuid\Uuid;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends PortalBaseModel
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

    protected $casts = ['is_protected' => 'bool'];

    /**
     * Add mass-assignment to model.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'name',
        'description',
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
     * This permission belongs to many roles.
     *
     * @return BelongsToMany
     */
    public function roles()
    {
        // belongsToMany('class','pivot_table','current_models_id','foreign_id')->withTimestamps()
        return $this->belongsToMany('App\Role', 'permissions_roles_pivot_table',
            'permission_id', 'role_id')->withTimestamps();
    }

    /**
     * Return the users associated with a given permission.
     *
     * @return Collection
     */
    public function users()
    {
        $users = new Collection();
        foreach ($this->roles as $role) {
            $users = $users->merge($role->users);
        }

        return $users;
    }

    /**
     *  This permission was created by a user.
     *
     * @return BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo('App\User', 'user_created_id', 'id');
    }

    /**
     *  This permission was updated by a user.
     *
     * @return BelongsTo
     */
    public function updatedBy()
    {
        return $this->belongsTo('App\User', 'user_updated_id', 'id');
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    /**
     * Return the list as needed by the role multiselect.
     *
     * @return array
     */
    public static function permissionsList()
    {
        $list_array = [];

        $permissions = static::orderBy('name')->get();
        foreach ($permissions as $permission) {
            $imploded = explode('.', $permission->name);
            $list_array[$imploded[0]][$permission->id] = $permission->name;
        }

        return $list_array;
    }
}
