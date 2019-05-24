<?php

namespace App;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;

class Ethnicity extends Model
{
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
     * Return a formatted dropdown for forms.
     *
     * @return mixed
     */
    public static function getDropdown()
    {
        return static::pluck('name', 'id')->all();
    }
}
