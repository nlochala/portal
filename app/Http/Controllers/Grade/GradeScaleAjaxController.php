<?php

namespace App\Http\Controllers;

use App\GradeScale;
use App\Helpers\FieldValidation;
use Illuminate\Database\Eloquent\Collection;

class GradeScaleAjaxController extends Controller
{
    protected $validation;
    protected $errors;
    protected $request;
    protected $eagerLoad;

    /**
     * Require users to have been authenticated before reaching this page.
     *
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->except('ajaxShow');
        $this->validation = new FieldValidation();
        $this->errors = false;
        $this->eagerLoad = [];
    }

    /*
        |--------------------------------------------------------------------------
        | AJAX METHODS
        |--------------------------------------------------------------------------
    */

    /**
     * This returns a json formatted array for the table.
     *
     * @return GradeScale[]|Collection
     */
    public function ajaxShow()
    {
        return GradeScale::with($this->eagerLoad)->get();
    }
}
