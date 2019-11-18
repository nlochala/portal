<?php

namespace App\Http\Controllers;

use App\AttendanceClass;
use App\AttendanceDay;
use App\CourseClass;
use App\GradeAverage;
use App\GradeQuarterAverage;
use App\Helpers\Helpers;
use App\Quarter;
use App\Student;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PPStudentController extends Controller
{
    /**
     * Show the student info page.
     *
     * @param Student $student
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function student(Student $student)
    {
        $this->authorize('view', $student);

        $quarter = Quarter::now();
        $quarters = Quarter::current()->get();

        $student->load(
            'status',
            'family.students.person',
            'family.students.status',
            'family.students.gradeLevel',
            'family.guardians.person',
            'family.guardians.type',
            'person.user.adGroups',
            'person.phones',
            'person.addresses'
        );

        $absences = AttendanceDay::isStudent($student->id)->isYear(env('SCHOOL_YEAR_ID'))->absent()->with('type')->get();

        $attendance_summary_array = [];
        $grades_summary_array = [];
        $grades_header = ['Class'];

        foreach (Quarter::current()->get() as $quarter_model) {
            $attendance_summary_array['Present'][$quarter_model->name] =
                AttendanceDay::isStudent($student->id)->isQuarter($quarter_model->id)->present()->count();
            $attendance_summary_array['Absent'][$quarter_model->name] =
                AttendanceDay::isStudent($student->id)->isQuarter($quarter_model->id)->absent()->count();
            $attendance_summary_array['Unexcused Tardies'][$quarter_model->name] =
                AttendanceClass::isStudent($student->id)->isQuarter($quarter_model->id)->unexcusedTardy()->count();
            $attendance_summary_array['Instructional Days'][$quarter_model->name] = $quarter_model->instructional_days;
        }

        foreach ($quarters as $q) {
            if ($q->name === Quarter::now()->name) {
                $grades_header[] = $q->name.'**';
            }else{
                $grades_header[] = $q->name;
            }
            $grades = GradeQuarterAverage::isQuarter($q->id)->isStudent($student->id)->get();
            $relationship = $q->getClassRelationship();
            $classes = CourseClass::isStudent($student->id, $relationship)->with('course')->get();

            foreach ($classes as $class) {
                if (! Carbon::parse($q->start_date)->lessThanOrEqualTo(now())) {
                    $grades_summary_array[$class->fullName][$q->name]['badge'] = '--';
                    $grades_summary_array[$class->fullName][$q->name]['link'] = null;
                } elseif ($grade = $grades->where('class_id', $class->id)->first()) {
                    $grades_summary_array[$class->fullName][$q->name]['badge'] = Helpers::colorPercentages($grade->percentage, $grade->percentage.'% '.$grade->grade_name);
                    $grades_summary_array[$class->fullName][$q->name]['link'] = "<a href=\"/s_student/report/grades/$class->uuid/$q->uuid/$student->uuid\">view</a>";
                }else{
                    $grades_summary_array[$class->fullName][$q->name]['badge'] = null;
                }

            }
        }

        $keys = array_keys($attendance_summary_array);
        array_unshift($keys, '');

        return view('student_portal.student', compact(
            'student',
            'grades',
            'classes',
            'quarter',
            'quarters',
            'grades_summary_array',
            'attendance_summary_array',
            'keys',
            'absences',
            'grades_header'
        ));
    }

    /**
     * Display the student details page for a specific class.
     *
     * @param CourseClass $class
     * @param Quarter $quarter
     * @param Student $student
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function studentDetails(CourseClass $class, Quarter $quarter, Student $student)
    {
        $this->authorize('view', $student);

        $quarters = $quarter->year->quarters;
        $class->load('primaryEmployee.person');
        $assignment_types = $class->assignmentTypes()->with('assignments.grades', 'gradeAverages')->get();
        $summary_array = $this->calculateDetails($assignment_types, $class, $quarters, $student);

        return view('student_portal.student_grade', compact('class', 'quarter', 'student', 'assignment_types', 'quarters', 'summary_array'));
    }

    /**
     * Display the student details page for a specific class.
     *
     * @param CourseClass $class
     * @param Quarter $quarter
     * @param Student $student
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function printStudentDetails(CourseClass $class, Quarter $quarter, Student $student)
    {
        $this->authorize('view', $student);

        $quarters = $quarter->year->quarters;
        $class->load('primaryEmployee.person');
        $assignment_types = $class->assignmentTypes()->with('assignments.grades', 'gradeAverages')->get();
        $summary_array = $this->calculateDetails($assignment_types, $class, $quarters, $student);

        return view('student_portal.student_print', compact('class', 'quarter', 'student', 'assignment_types', 'quarters', 'summary_array'));
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
                    $percentage = empty($average->max_points) ? '--' : round((($average->points_earned / $average->max_points) * 100), 2).'%';
                }
                $summary_array[$type_name][$q->name] = $percentage;
            }
        }
        foreach ($quarters as $q) {
            if ($quarter_average = GradeQuarterAverage::isStudent($student->id)->isQuarter($q->id)->isClass($class->id)->first()) {
                $total = $quarter_average->percentage.'% '.$quarter_average->grade_name;
                if (Carbon::parse($q->start_date)->isFuture()) {
                    $total = '--';
                }
            } else {
                $total = '--';
            }

            $summary_array['TOTAL'][$q->name] = $total;
        }

        return $summary_array;
    }
}
