<?php

namespace App\Http\Controllers;

use App\Year;
use Illuminate\View\View;
use Illuminate\Contracts\View\Factory;

class HolidayController extends Controller
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
        $quarters = $year->quarters;

        return view('year.holiday', compact('year', 'years', 'quarters'));
    }
}
