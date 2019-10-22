<?php

namespace App\Http\Controllers;

use App\CourseClass;
use App\GradeQuarterAverage;
use App\Person;
use App\Quarter;
use App\Student;
use App\GradeLevel;
use App\StudentStatus;
use App\Helpers\Helpers;
use Illuminate\View\View;
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

        return view('student.dashboard', compact('student', 'grades', 'classes', 'quarter'));
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
        $values = Helpers::dbAddAudit(request()->all());
        $values['gender'] = Person::getGender($values['gender']);
        $person = Person::create($values);

        $student_values['person_id'] = $person->id;
        $student_values['grade_level_id'] = $values['grade_level_id'];
        $student_values['student_status_id'] = $values['student_status_id'];
        $student_values['start_date'] = $values['start_date'];
        $student_values['end_date'] = $values['end_date'];

        $values = Helpers::dbAddAudit($student_values);
        $student = Student::create($values);

        Helpers::flash($student, 'student');

        if ($student) {
            $student->searchable();

            return redirect()->to('student/'.$student->uuid.'/profile');
        }

        return redirect()->back()->withInput();
    }
}
