<?php

namespace App\Http\Controllers;

use App\AttendanceClass;
use App\Helpers\DatabaseHelpers;
use App\Helpers\ViewHelpers;
use App\Person;
use App\Quarter;
use App\Student;
use App\GradeLevel;
use App\CourseClass;
use App\AttendanceDay;
use App\StudentStatus;
use App\Helpers\Helpers;
use Illuminate\View\View;
use App\GradeQuarterAverage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;

class StudentController extends Controller
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
     * Show the dashboard for the student.
     *
     * @param Student $student
     * @return Factory|View
     */
    public function dashboard(Student $student)
    {
        $quarter = Quarter::now();
        $relationship = $quarter->getClassRelationship();

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

        $grades = GradeQuarterAverage::isQuarter($quarter->id)->isStudent($student->id)->get();
        $classes = CourseClass::isStudent($student->id, $relationship)->with('course')->get();
        $absences = AttendanceDay::isStudent($student->id)->isQuarter($quarter->id)->absent()->with('type')->get();

        $attendance_summary_array = [];

        foreach (Quarter::current()->get() as $quarter_model) {
            $attendance_summary_array['Present'][$quarter_model->name] =
                AttendanceDay::isStudent($student->id)->isQuarter($quarter_model->id)->present()->count();
            $attendance_summary_array['Absent'][$quarter_model->name] =
                AttendanceDay::isStudent($student->id)->isQuarter($quarter_model->id)->absent()->count();
            $attendance_summary_array['Unexcused Tardies'][$quarter_model->name] =
                AttendanceClass::isStudent($student->id)->isQuarter($quarter_model->id)->unexcusedTardy()->count();
            $attendance_summary_array['Instructional Days'][$quarter_model->name] = $quarter_model->instructional_days;
        }

        $keys = array_keys($attendance_summary_array);
        array_unshift($keys, '');

        return view('student.dashboard', compact(
            'student',
            'grades',
            'classes',
            'quarter',
            'attendance_summary_array',
            'keys',
            'absences'
        ));
    }

    /**
     * Display an index of all students.
     *
     * @return Factory|View
     */
    public function index()
    {
        $title_dropdown = Person::$titleDropdown;
        $gender_dropdown = Person::$genderRadio;
        $student_status_dropdown = StudentStatus::getDropdown();
        $grade_level_dropdown = GradeLevel::getDropdown();

        return view('student.index', compact(
            'gender_dropdown',
            'title_dropdown',
            'student_status_dropdown',
            'grade_level_dropdown'
        ));
    }

    /**
     * Store a new student.
     *
     * @return RedirectResponse
     */
    public function storeNewStudent()
    {
        $values = DatabaseHelpers::dbAddAudit(request()->all());
        $values['gender'] = Person::getGender($values['gender']);
        $person = Person::create($values);

        $student_values['person_id'] = $person->id;
        $student_values['grade_level_id'] = $values['grade_level_id'];
        $student_values['student_status_id'] = $values['student_status_id'];
        $student_values['start_date'] = $values['start_date'];
        $student_values['end_date'] = $values['end_date'];

        $values = DatabaseHelpers::dbAddAudit($student_values);
        $student = Student::create($values);

       ViewHelpers::flash($student, 'student');

        if ($student) {
            $student->searchable();

            return redirect()->to('student/'.$student->uuid.'/profile');
        }

        return redirect()->back()->withInput();
    }
}
