<?php

namespace App\Http\Controllers;

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
        $grade_levels = GradeLevel::getDropdown('current');

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
        $grade_level = GradeLevel::find($values['grade_level']);

        $students = Student::grade($grade_level->short_name)
            ->with('person', 'reportCardPercentages.classGrades', 'reportCardPercentages.behaviorGrade')->get();

        return view('report_card.print', compact('students'));
    }
}
