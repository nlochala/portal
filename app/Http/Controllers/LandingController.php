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
        } elseif ($employee = auth()->user()->person->employee) {
            return redirect()->to('employee/'.$employee->uuid);
        }

        return view('landing');
    }
}
