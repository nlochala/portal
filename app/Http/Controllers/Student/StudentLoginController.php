<?php

namespace App\Http\Controllers;

use App\Helpers\DatabaseHelpers;
use App\Helpers\ViewHelpers;
use App\Student;
use App\Helpers\Helpers;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;

class StudentLoginController extends Controller
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
     * Display the logins for students.
     *
     * @return Factory|View
     */
    public function index()
    {
        $students = Student::with('gradeLevel', 'person')->get();

        return view('logins.student_logins', compact('students'));
    }

    /**
     * Export Logins.
     *
     * @return Factory|View
     */
    public function loginsExport()
    {
        $students = Student::with('person')->current()->isImported(false)->get();

        foreach ($students as $student) {
            if ($student->username === null) {
                $lastname = preg_replace('/[^A-Za-z0-9]/', '', $student->person->family_name);
                $student->username = $student->id.strtolower($lastname).'@tlcdg.com';
                $student->password = 'tlc123'.chr(rand(65, 90)).chr(rand(65, 90));
                $student->save();
            }
        }

        return view('logins.student_export', compact('students'));
    }

    /**
     * Mark a student as imported.
     *
     * @return RedirectResponse
     */
    public function imported()
    {
        $students = Student::with('person')->current()->isImported(false)->get();

        foreach ($students as $student) {
            $student = DatabaseHelpers::dbAddAudit($student);
            $student->is_imported = true;
           ViewHelpers::flash($student->save(), 'student', 'updated');
        }

        return redirect()->back();
    }
}
