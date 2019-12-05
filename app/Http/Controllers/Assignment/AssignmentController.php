<?php

namespace App\Http\Controllers;

use App\Quarter;
use App\Assignment;
use App\CourseClass;
use App\AssignmentType;
use Illuminate\View\View;
use Illuminate\Contracts\View\Factory;

class AssignmentController extends Controller
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
     * Show the index page of assignments for a given class.
     *
     * @param CourseClass $class
     * @param Quarter $quarter
     * @return Factory|View
     */
    public function index(CourseClass $class, Quarter $quarter)
    {
        $assignment_types = AssignmentType::getDropdown('courseClass', $class->id);
        $quarters = Quarter::getDropdown();

        return view('gradebook.assignments', compact('class', 'quarter', 'assignment_types', 'quarters'));
    }

    /**
     * @param CourseClass $class
     * @param Quarter $quarter
     * @param Assignment $assignment
     * @return Factory|View
     */
    public function grade(CourseClass $class, Quarter $quarter, Assignment $assignment)
    {
        $current_students = $class->currentStudents($quarter, 'current');
        $former_students = $class->currentStudents($quarter, 'former');
        $incoming_students = $class->currentStudents($quarter, 'incoming');
        $assignment->load('grades');

        return view('gradebook.assignment_grade', compact(
            'class',
            'quarter',
            'assignment',
            'current_students',
            'former_students',
            'incoming_students'
        ));
    }
}
