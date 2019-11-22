<?php

namespace App;

use Illuminate\Notifications\Notification;
use Webpatser\Uuid\Uuid;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

//    protected $with = ['person'];

    /*
    |--------------------------------------------------------------------------
    | SETUP
    |--------------------------------------------------------------------------
    */
    /**
     * The channels the user receives notification broadcasts on.
     *
     * @return string
     */
    public function receivesBroadcastNotificationsOn()
    {
        return 'user.'.$this->uuid;
    }

    /**
     * Route notifications for the Slack channel.
     *
     * @param  Notification  $notification
     * @return string
     */
    public function routeNotificationForSlack($notification)
    {
        return env('SLACK_HOOK');
    }

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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'name',
        'email',
        'password',
    ];

    /*
    |--------------------------------------------------------------------------
    | ATTRIBUTES
    |--------------------------------------------------------------------------
    */

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
     * Many users belongs to many roles.
     *
     * @return BelongsToMany
     */
    public function roles()
    {
        // belongsToMany('class','pivot_table','current_models_id','foreign_id')->withTimestamps()
        return $this->belongsToMany('App\Role', 'roles_users_pivot_table', 'user_id', 'role_id')->withTimestamps();
    }

    /**
     *  This uer belongs to a person.
     *
     * @return BelongsTo
     */
    public function person()
    {
        return $this->belongsTo('App\Person', 'person_id', 'id');
    }

    /**
     * Many users belongs to many ad_groups.
     *
     * @return BelongsToMany
     */
    public function adGroups()
    {
        // belongsToMany('class','pivot_table','current_models_id','foreign_id')->withTimestamps()
        return $this->belongsToMany('App\AdGroup', 'ad_groups_users_pivot', 'user_id', 'ad_group_id')->withTimestamps();
    }

    /**
     * This user has a File.
     *
     * @return HasOne
     */
    public function thumbnail()
    {
        // 6 --> this is the key for the relationship on the table defined on 4
        return $this->hasOne('App\File', 'id', 'thumbnail_file_id');
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    /**
     * Pass a role name or role object and see if the user is a member.
     *
     * @param $role
     *
     * @return bool
     */
    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->roles->contains('name', $role);
        }

        return (bool) $role->intersect($this->roles)->count();
    }

    /**
     * Check if user is an admin.
     *
     * @return bool
     */
    public function isAdmin()
    {
        $roles = $this->roles->pluck('name')->toArray();

        return in_array('portal-admin', $roles);
    }

    /**
     * Display a user's thumbnail image.
     *
     * @return mixed
     */
    public function displayThumbnail()
    {
        if (isset($this->person->gender)) {
            $gender = strtolower($this->person->gender);
            if ($file = File::where('name', "default-$gender")->first()) {
                return $file->renderImage();
            }
        }

        $file = File::where('name', 'default-male')->first();

        return $file->renderImage();
    }
}
