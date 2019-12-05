<?php

namespace App;

use Webpatser\Uuid\Uuid;

class Country extends PortalBaseModel
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
     * Return a formatted dropdown list for forms.
     *
     * @return mixed
     */
    public static function getDropdown()
    {
        return static::pluck('name', 'id')->all();
    }

    /**
     * Return a formatted dropdown list for phone forms.
     *
     * @return array
     */
    public static function getCountryCodeDropdown()
    {
        $array = static::all(['id', 'name', 'country_code']);
        $return_array = [];

        foreach ($array as $item) {
            $return_array[$item->id] = $item->name.' (+'.$item->country_code.')';
        }

        return $return_array;
    }
}
