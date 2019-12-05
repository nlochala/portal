<?php

namespace App\Http\Controllers;

use App\GradeLevel;
use App\Quarter;
use App\Student;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MidQuarterReportController extends Controller
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
     * @return Factory|View
     */
    public function academicDanger()
    {
        $quarter = Quarter::now();
        $grade_level = GradeLevel::secondary()->current()->get();
        $grade_array = [];

        foreach($grade_level as $grade) {
            $grade_array[$grade->name] = Student::grade($grade->short_name)
                ->with('person','gradeQuarterAverages.class')
                ->academicDanger($quarter->id)
                ->current()
                ->get();
        }


        return view('report.academic_danger', compact('grade_array','quarter'));
    }
}

