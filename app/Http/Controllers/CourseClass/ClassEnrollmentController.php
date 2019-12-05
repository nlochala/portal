<?php

namespace App\Http\Controllers;

use App\Quarter;
use App\CourseClass;
use App\Helpers\Helpers;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;

class ClassEnrollmentController extends ClassController
{
    /**
     * Display the enrollment form.
     *
     * @param CourseClass $class
     * @param string $filter
     * @return Factory|View
     */
    public function enrollment(CourseClass $class, $filter = 'gradeLevels')
    {
        $class->load(
            'course',
            'q1Students.person',
            'q1Students.gradeLevel',
            'q1Students.status',
            'q2Students.person',
            'q2Students.gradeLevel',
            'q2Students.status',
            'q3Students.person',
            'q3Students.gradeLevel',
            'q3Students.status',
            'q4Students.person',
            'q4Students.gradeLevel',
            'q4Students.status',
            'primaryEmployee.person',
            'secondaryEmployee.person',
            'taEmployee.person',
            'room.building',
            'year',
            'status'
        );

        $enrollment_lists = $class->course->getEnrollmentLists($filter);
        $q1Enrollment = $class->q1Students->pluck('id')->toArray();
        $q2Enrollment = $class->q2Students->pluck('id')->toArray();
        $q3Enrollment = $class->q3Students->pluck('id')->toArray();
        $q4Enrollment = $class->q4Students->pluck('id')->toArray();
        $quarter_dropdown = Quarter::getDropdown('current');

        $quarters = Quarter::current()->get();

        $view = $class->students->count() ? 'class.edit_enrollment' : 'class.new_enrollment';

        return view($view, compact(
            'class',
            'enrollment_lists',
            'q1Enrollment',
            'q2Enrollment',
            'q3Enrollment',
            'q4Enrollment',
            'quarter_dropdown',
            'quarters'
        ));
    }

    /**
     * Save the initial enrollment changes.
     *
     * @param CourseClass $class
     * @return RedirectResponse
     */
    public function storeEnrollment(CourseClass $class)
    {
        $values = request()->all();

        if (! isset($values['students'])) {
            $values['students'] = [];
        }

        foreach ($values['quarters'] as $quarter) {
            $relationship = Quarter::find($quarter)->getClassRelationship();
            Helpers::flash($class->$relationship()->sync($values['students']), 'enrollment', 'updated');
        }

        return redirect()->back();
    }

    /**
     * Update the individual quarter enrollments.
     *
     * @param CourseClass $class
     * @param $filter
     * @param Quarter $quarter
     * @return RedirectResponse
     */
    public function updateEnrollment(CourseClass $class, $filter, Quarter $quarter)
    {
        $values = request()->all();

        if (! isset($values['students'])) {
            $values['students'] = [];
        }

        $relationship = $quarter->getClassRelationship();
        Helpers::flash($class->$relationship()->sync($values['students']), 'enrollment', 'updated');

        return redirect()->back();
    }
}
