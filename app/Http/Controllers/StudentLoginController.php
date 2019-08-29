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

        return view('logins.student_export', compact('students'));
    }
}
