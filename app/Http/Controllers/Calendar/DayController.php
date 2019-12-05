<?php

namespace App\Http\Controllers;

use App\Day;
use App\Year;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DayController extends Controller
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

    /**
     * Display a list of holidays for a given year.
     *
     * @param Year $year
     * @return Factory|View
     */
    public function index(Year $year)
    {
        $years = Year::all();
        $quarters = $year->quarters()->with('days')->get();

        return view('year.day', compact('year', 'years', 'quarters'));
    }
}

