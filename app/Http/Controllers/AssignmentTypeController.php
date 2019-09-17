<?php

namespace App\Http\Controllers;

use App\CourseClass;
use App\Quarter;
use Illuminate\View\View;
use Illuminate\Contracts\View\Factory;

class AssignmentTypeController extends Controller
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
     * Display the assignment types.
     *
     * @param CourseClass $class
     * @param Quarter $quarter
     * @return Factory|View
     */
    public function index(CourseClass $class, Quarter $quarter)
    {
        return view('gradebook.assignment_types', compact('class', 'quarter'));
    }
}
