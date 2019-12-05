<?php

namespace App\Http\Controllers;

use App\School;
use App\Year;
use Illuminate\View\View;
use Illuminate\Contracts\View\Factory;

class GradeLevelController extends Controller
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
     * Display all the grade levels.
     *
     * @return Factory|View
     */
    public function index()
    {
        $years = Year::all();
        $schools = School::all();

        return view('grade_level.index', compact('years', 'schools'));
    }
}
