<?php

namespace App\Http\Controllers;

use App\Quarter;
use App\Year;

class QuarterController extends Controller
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

    public function index()
    {
        $year_dropdown = Year::getDropdown();
        $name_dropdown = Quarter::$name;

        return view('year.quarter', compact(
            'year_dropdown',
            'name_dropdown'
        ));
    }
}
