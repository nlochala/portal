<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ethnicity extends Model
{
    /**
     * Return a formatted dropdown for forms
     *
     * @return mixed
     */
    public static function getDropdown()
    {
        return static::pluck('name','id')->all();
    }
}
