<?php

namespace App;

use Carbon\Carbon;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ParentMessage extends PortalBaseModel
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

        // Order by name ASC
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('created_at', 'desc');
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

    protected $casts = [
        'is_protected' => 'bool',
        'is_read' => 'bool',
    ];

    /**
     * Add mass-assignment to model.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'to_model',
        'from_model',
        'to_id',
        'from_id',
        'class_id',
        'message_family_id',
        'is_read',
        'read_on',
        'subject',
        'body',
        'is_protected',
        'user_created_id',
        'user_created_ip',
        'user_updated_id',
        'user_updated_ip',
    ];

    /**
     * We want to match something with the from and to models.
     *
     * @param $model
     * @return string
     */
    public static function getModelName($model)
    {
        $str = preg_replace("/App\\\/", '', get_class($model));

        return strtolower($str);
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

    /**
     * get to messages query scope.
     *
     * @param $query
     */
    public function scopeRecipient($query, $model)
    {
        $query->where('to_model', static::getModelName($model))
            ->where('to_id', $model->id);
    }

    /**
     * get from messages query scope.
     *
     * @param $query
     */
    public function scopeAuthor($query, $model)
    {
        $query->where('from_model', static::getModelName($model))
            ->where('from_id', $model->id);
    }

    /**
     * get from messages query scope.
     *
     * @param $query
     * @param $model_name
     */
    public function scopeRecipientModel($query, $model_name)
    {
        $query->where('from_model', $model_name);
    }

    /**
     * get from messages query scope.
     *
     * @param $query
     * @param $model_name
     */
    public function scopeAuthorModel($query, $model_name)
    {
        $query->where('from_model', $model_name);
    }

    /**
     * unread query scope.
     *
     * @param $query
     * @param $class_id
     */
    public function scopeIsClass($query, $class_id)
    {
        $query->where('class_id', $class_id);
    }

    /**
     * unread query scope.
     *
     * @param $query
     */
    public function scopeUnread($query)
    {
        $query->where('is_read', false);
    }

    /**
     * unread query scope.
     *
     * @param $query
     */
    public function scopeRead($query)
    {
        $query->where('is_read', true);
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /**
     *  This message_family has many messages.
     *
     * @return HasMany
     */
    public function messages()
    {
        return $this->hasMany('App\ParentMessages', 'message_family_id');
    }

    /**
     *  This message belongs to a class.
     *
     * @return BelongsTo
     */
    public function class()
    {
        return $this->belongsTo('App\CourseClass', 'class_id', 'id');
    }

    /**
     *  This message belongs to a from.
     *
     * @return BelongsTo
     */
    public function from()
    {
        $model = ucwords($this->from_model);

        return $this->belongsTo('App\\'.$model, 'from_id', 'id');
    }

    /**
     *  This message belongs to a to.
     *
     * @return BelongsTo
     */
    public function to()
    {
        $model = ucwords($this->to_model);

        return $this->belongsTo('App\\'.$model, 'to_id', 'id');
    }

    /**
     *  This message was created by a user.
     *
     * @return BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo('App\User', 'user_created_id', 'id');
    }

    /**
     *  This message was updated by a user.
     *
     * @return BelongsTo
     */
    public function updatedBy()
    {
        return $this->belongsTo('App\User', 'user_updated_id', 'id');
    }
}
