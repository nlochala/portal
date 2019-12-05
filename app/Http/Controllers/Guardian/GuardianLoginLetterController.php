<?php

namespace App\Http\Controllers;

use App\CourseClass;
use App\GradeLevel;
use App\Quarter;
use App\Student;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class GuardianLoginLetterController extends Controller
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
     * Show the print form.
     *
     * @return Factory|View
     */
    public function form()
    {
        $grade_level_dropdown = GradeLevel::getDropdown('current', null, false);
        $student_dropdown = Student::getDropdown();
        $class_dropdown = CourseClass::getDropdown('active');

        return view('logins.welcome_form', compact('grade_level_dropdown', 'student_dropdown', 'class_dropdown'));
    }

    /**
     * Print the requested welcome letters.
     *
     * @return Factory|View
     */
    public function print()
    {
        $relationship = Quarter::now()->getClassRelationship();
        $students = new Collection();

        $student_id = request()->get('student_id');
        $class_id = request()->get('class_id');
        $grade_level_id = request()->get('grade_level_id');

        if ($student_id) {
            $students = Student::where('id', $student_id)->with('family.guardians.person', 'person', 'gradeLevel')->get();
        }

        if ($class_id) {
            $class = CourseClass::findOrFail($class_id);
            $students = $class->$relationship()->with('family.guardians.person', 'person', 'gradeLevel')->get();
        }

       if ($grade_level_id)  {
           $grade_level = GradeLevel::findOrFail($grade_level_id);
           $students = $grade_level->students()->with('family.guardians.person', 'person', 'gradeLevel')->get();
       }

       return view('logins.welcome_print', compact('students'));
    }
}
