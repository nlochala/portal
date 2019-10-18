<?php

namespace App\Http\Controllers;

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
        $quarters = $quarter->year->quarters;
        $class->load('primaryEmployee.person');
        $assignment_types = $class->assignmentTypes()->with('assignments.grades', 'gradeAverages')->get();
        $summary_array = $this->calculateDetails($assignment_types, $class, $quarters, $student);

        return view('gradebook.student', compact('class', 'quarter', 'student', 'assignment_types', 'quarters', 'summary_array'));
    }

    /**
     * Display the student details page for a specific class.
     *
     * @param CourseClass $class
     * @param Quarter $quarter
     * @param Student $student
     * @return Factory|View
     */
    public function printStudentDetails(CourseClass $class, Quarter $quarter, Student $student)
    {
        $quarters = $quarter->year->quarters;
        $class->load('primaryEmployee.person');
        $assignment_types = $class->assignmentTypes()->with('assignments.grades', 'gradeAverages')->get();
        $summary_array = $this->calculateDetails($assignment_types, $class, $quarters, $student);

        return view('gradebook.student_print', compact('class', 'quarter', 'student', 'assignment_types', 'quarters', 'summary_array'));
    }

    /**
     * Return the student details.
     *
     * @param $assignment_types
     * @param $class
     * @param $quarters
     * @param $student
     * @return array
     */
    private function calculateDetails($assignment_types, $class, $quarters, $student)
    {
        $summary_array = [];

        foreach ($assignment_types as $type) {
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

        return $summary_array;
    }
}
