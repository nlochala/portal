<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LandingController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request)
    {
        if (! auth()->user()) {
            return redirect()->route('login');

        } elseif (auth()->user()->can('student-only')) {
            return redirect()->to('s_student/student/'.auth()->user()->person->student->uuid);

        } elseif (auth()->user()->can('guardian-only')) {
            return redirect()->to('g_guardian/guardian');

        } elseif ($employee = auth()->user()->person->employee) {
            return redirect()->to('employee/'.$employee->uuid);
        }

        return view('landing');
    }
}

