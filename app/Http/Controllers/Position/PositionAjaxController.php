<?php

namespace App\Http\Controllers;

use App\Position;
use App\Helpers\FieldValidation;
use Illuminate\Database\Eloquent\Collection;

class PositionAjaxController extends Controller
{
    protected $validation;

    /**
     * Require users to have been authenticated before reaching this page.
     *
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->except('ajaxShow');
        $this->validation = new FieldValidation();
    }

    /**
     * This returns a json formatted array for the table.
     *
     * @return Position[]|Collection
     */
    public function ajaxShow()
    {
        return Position::with(['type', 'school', 'supervisor'])->get();
    }
}
