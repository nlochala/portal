<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\View\View;
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
        $students = Student::with('person')->current()->whereNull('username')->orWhereNull('password')->get();
        foreach ($students as $student) {
            $lastname = preg_replace('/[^A-Za-z0-9]/', '', $student->person->family_name);
            $student->username = $student->id.strtolower($lastname).'@tlcdg.com';
            $student->password = 'tlc123'.chr(rand(65, 90)).chr(rand(65, 90));
//            $student->save();
        }

        return view('logins.student_export', compact('students'));
    }
}
