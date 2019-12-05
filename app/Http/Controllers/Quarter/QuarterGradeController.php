<?php

namespace App\Http\Controllers;

use App\Quarter;
use App\Student;

class QuarterGradeController extends Controller
{
    /**
     * Require users to have been authenticated before reaching this page.
     *
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
}
