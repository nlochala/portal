<?php

if (! function_exists('is_guardian')) {
    /**
     * @return mixed
     */
    function is_guardian()
    {
        return auth()->user()->can('guardian-only');
    }
}

if (! function_exists('is_employee')) {
    /**
     * @return mixed
     */
    function is_employee()
    {
        return auth()->user()->person->employee && ! is_guardian() ? true : false;
    }
}

if (! function_exists('is_student')) {
    /**
     * @return mixed
     */
    function is_student()
    {
        return auth()->user()->can('student-only');
    }
}

if (! function_exists('shorten_string')) {
    /**
     * @param $string
     * @param int $max_characters
     * @return mixed
     */
    function shorten_string($string, $max_characters = 20)
    {
        return strlen($string) > $max_characters
            ? substr($string, 0, $max_characters).'...'
            : $string;
    }
}
