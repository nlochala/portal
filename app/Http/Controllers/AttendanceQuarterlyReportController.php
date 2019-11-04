<?php

namespace App\Http\Controllers;

use App\AttendanceClass;
use App\Quarter;
use App\CourseClass;
use App\AttendanceDay;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;

class AttendanceQuarterlyReportController extends Controller
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
     * Return the view for the report form.
     *
     * @return Factory|View
     */
    public function reportForm()
    {
        $quarters = Quarter::getDropdown(null, env('SCHOOL_YEAR_ID'));
        $classes = CourseClass::getDropdown('active');

        return view('attendance.quarterly_report_form', compact('quarters', 'classes'));
    }

    /**
     * Process the form and give it to the report method.
     *
     * @return RedirectResponse
     */
    public function processForm()
    {
        $values = request()->all();
        $quarter = Quarter::findOrFail($values['quarter_id']);
        $class = CourseClass::findOrFail($values['class_id']);

        return redirect()->to('/attendance/quarterly_report/'.$quarter->uuid.'/'.$class->uuid);
    }

    /**
     * Display the attendance report.
     *
     * @param Quarter $quarter
     * @param CourseClass $class
     * @return Factory|View
     */
    public function report(Quarter $quarter, CourseClass $class)
    {
        $attendance = [];

        $relationship = $quarter->getClassRelationship();
        $students = $class->$relationship()->with('person')->get();

        foreach ($students as $student) {
            $attendance[$student->name]['present'] = AttendanceDay::isQuarter($quarter->id)
                ->isStudent($student->id)->present()->count();
            $attendance[$student->name]['absent'] = AttendanceDay::isQuarter($quarter->id)
                ->isStudent($student->id)->absent()->count();
            $attendance[$student->name]['tardies'] = AttendanceClass::isQuarter($quarter->id)
                ->isStudent($student->id)->unexcusedTardy()->count();
        }

        return view('attendance.quarterly_report', compact('attendance', 'quarter', 'class'));
    }
}
