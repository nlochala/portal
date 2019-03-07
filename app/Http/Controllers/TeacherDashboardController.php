<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeacherDashboardController extends Controller
{
    /**
     * Return the teacher dashboard
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('teacher_dashboard');
    }
}
