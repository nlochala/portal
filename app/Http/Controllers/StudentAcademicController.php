<?php

namespace App\Http\Controllers;

use Request;
use App\Student;
use App\GradeLevel;
use App\StudentStatus;
use App\Helpers\Helpers;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;

class StudentAcademicController extends StudentController
{
    /**
     * Return the overview view.
     *
     * @param Student $student
     * @return Factory|View
     */
    public function overview(Student $student)
    {
        $student_status_dropdown = StudentStatus::getDropdown();
        $grade_level_dropdown = GradeLevel::getDropdown();

        return view('student.academic_overview', compact(
            'student',
            'student_status_dropdown',
            'grade_level_dropdown'
        ));
    }

    /**
     * Store the overview form.
     *
     * @param Student $student
     * @return RedirectResponse
     */
    public function storeOverview(Student $student)
    {
        $values = Helpers::dbAddAudit(Request::all());
        if (empty($values['end_date']) &&
            ($values['student_status_id'] === '4' || $values['student_status_id'] === '5')) {
            Helpers::flashAlert(
                'danger',
                'An end date is required when changing a student\'s status to \"Former Student\" or \"Graduated\". Please try again.',
                'fa fa-info-circle mr-1');

            return redirect()->back()->withInput();
        }

        Helpers::flash($student->update($values), 'student academic overview', 'updated');

        return redirect()->back();
    }
}
