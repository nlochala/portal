<?php

namespace App\Http\Controllers;

use App\Phone;
use App\Person;
use App\Address;
use App\Country;
use App\Student;
use App\PhoneType;
use App\GradeLevel;
use App\AddressType;
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
            return redirect()->to('student/'.$student->uuid.'/profile');
        }

        return redirect()->back()->withInput();
    }
}
