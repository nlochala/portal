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
