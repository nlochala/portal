<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    /**
     * Get dropdown list for forms
     *
     * @return mixed
     */
    public static function getDropdown()
    {
        return static::pluck('name','id')->all();
    }
}
