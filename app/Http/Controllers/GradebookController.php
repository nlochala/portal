<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Quarter;
use App\Student;
use App\Assignment;
use App\CourseClass;
use App\GradeAverage;
use Illuminate\View\View;
use App\GradeQuarterAverage;
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

    /**
     * Display the student details page for a specific class.
     *
     * @param CourseClass $class
     * @param Quarter $quarter
     * @param Student $student
     * @return Factory|View
     */
    public function studentDetails(CourseClass $class, Quarter $quarter, Student $student)
    {
        $summary_array = [];
        $quarters = $quarter->year->quarters;
        $assignment_types = $class->assignmentTypes()->with('assignments.grades', 'gradeAverages')->get();
        foreach ($assignment_types as $type) {
//            dd($type->assignments->first());
            $type_name = $type->name.' -- '.$type->weight.'%';
            foreach ($quarters as $q) {
                $percentage = '--';
                $total = '--';
                if ($average = GradeAverage::isStudent($student->id)->isQuarter($q->id)->isAssignmentType($type->id)->first()) {
                    $percentage = empty($average->max_points) ?: round((($average->points_earned / $average->max_points) * 100), 2).'%';
                }
                $summary_array[$type_name][$q->name] = $percentage;
            }
        }
        foreach ($quarters as $q) {
            if ($quarter_average = GradeQuarterAverage::isStudent($student->id)->isQuarter($q->id)->isClass($class->id)->first()) {
                $total = $quarter_average->percentage.'% '.$quarter_average->grade_name;
            } else {
                $total = '--';
            }

            $summary_array['TOTAL'][$q->name] = $total;
        }

//        dd($summary_array);

        return view('gradebook.student', compact('class', 'quarter', 'student', 'assignment_types', 'quarters', 'summary_array'));
    }
}
