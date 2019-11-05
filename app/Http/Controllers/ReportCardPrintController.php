<?php

namespace App\Http\Controllers;

use App\GradeScale;
use App\Year;
use App\Quarter;
use App\Student;
use App\GradeLevel;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;

class ReportCardPrintController extends Controller
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
     * Choose the year to print.
     *
     * @param Year $year
     * @return Factory|View
     */
    public function reportForm(Year $year)
    {
        $years_dropdown = Year::getDropdown();
        $quarter_dropdown = Quarter::getDropdown(null, $year->id);
        $grade_levels = GradeLevel::getDropdown('current', 'secondary');

        return view('report_card.form', compact('years_dropdown', 'quarter_dropdown', 'grade_levels', 'year'));
    }

    /**
     * Process a change of school year.
     */
    public function changeYear()
    {
        if ($year = request()->get('year')) {
            return $this->reportForm(Year::findOrFail($year));
        }

        return $this->reportForm(Year::currentYear());
    }

    /**
     * Generate the reports based on the results from the print form.
     */
    public function generateReports()
    {
        $values = request()->all();
        $quarter = Quarter::findOrFail($values['quarter_id']);
        $quarters = Year::currentYear()->quarters;
        $grade_level = GradeLevel::find($values['grade_level']);
        $percentage_scale = GradeScale::where('name', 'Percentage (Sub-divided)')->first();
        $behavior_scale = GradeScale::where('name', 'Default - Non-academic')->first();
        $grades = [];
        $homeroom = [];

        $students = Student::grade($grade_level->short_name)->current()
            ->with('person', 'reportCardPercentages.classGrades.class.course', 'reportCardPercentages.behaviorGrade', 'reportCardPercentages.quarter')->get();

        foreach ($students as $student) {
            foreach ($student->reportCardPercentages as $report) {
                foreach ($report->classGrades as $grade) {
                    if (strpos($grade->class->fullName, 'Homeroom') !== false) {
                        $homeroom[$student->id] = $grade->class;
                    } else {
                        $grades[$student->id][$grade->class->fullName][$report->quarter_id] = $grade->grade;
                    }
                }
            }
        }

//        dd($students->first()->reportCardPercentages->first());

        return view('report_card.print',
            compact('students', 'quarter', 'grades', 'quarters', 'homeroom', 'percentage_scale', 'behavior_scale'));
    }
}
