<?php

namespace App\Http\Controllers;

use App\CourseClass;
use Illuminate\View\View;
use Illuminate\Contracts\View\Factory;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MapRosterController extends Controller
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
     * Return the index for the roster file.
     *
     * @return Factory|View
     */
    public function index()
    {
        $classes = CourseClass::with('q1Students.person.ethnicity', 'primaryEmployee.person', 'course', 'q1Students.gradeLevel')->get();

        return view('map.export', compact('classes'));
    }
}
