<?php

namespace App\Http\Controllers;

use App\Quarter;
use App\Assignment;
use App\CourseClass;
use Illuminate\View\View;
use Illuminate\Contracts\View\Factory;

class GradebookController extends Controller
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
     * Show the gradebook overview.
     *
     * @param CourseClass $class
     * @param Quarter $quarter
     * @return Factory|View
     */
    public function show(CourseClass $class, Quarter $quarter)
    {
        $current_students = $class->currentStudents($quarter, 'current', ['gradeAverages', 'gradeQuarterAverages']);
        $former_students = $class->currentStudents($quarter, 'former', ['gradeAverages', 'gradeQuarterAverages']);
        $incoming_students = $class->currentStudents($quarter, 'incoming', ['gradeAverages', 'gradeQuarterAverages']);
        $assignments = Assignment::courseClass($class->id)->quarter($quarter->id)->with('grades.student', 'type')->get();
        $grades_array = [];
        $excused_array = [];

        foreach ($assignments as $assignment) {
            $grades_array[$assignment->id] = $assignment->grades->pluck('points_earned', 'student.id')->toArray();
            $excused_array[$assignment->id] = $assignment->grades->pluck('is_excused', 'student.id')->toArray();
        }

        $table_head = ['Name', 'TOTAL'];
        foreach ($assignments as $assignment) {
            $table_head[] = "<a href='/class/$class->uuid/$quarter->uuid/gradebook/assignment/$assignment->uuid'>$assignment->name</a>";
        }

        return view('gradebook.show', compact(
            'class',
            'quarter',
            'current_students',
            'former_students',
            'incoming_students',
            'assignments',
            'table_head',
            'grades_array',
            'excused_array'
        ));
    }
}
