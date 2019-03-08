<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TeacherDashboardController extends Controller
{
    /**
     * Return the teacher dashboard
     *
     * @param User $id
     * @return Factory|View
     */
    public function index(User $id)
    {
        return view('teacher_dashboard');
    }
}
