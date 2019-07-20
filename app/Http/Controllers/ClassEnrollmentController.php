<?php

namespace App\Http\Controllers;

use App\CourseClass;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class ClassEnrollmentController extends ClassController
{
    /**
     * Display the enrollment form.
     *
     * @param CourseClass $class
     * @return Factory|View
     */
    public function enrollment(CourseClass $class)
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

        $enrollment_lists = $class->course->getEnrollmentLists();
        $enrollment = $class->q1Students;

        return view('class.edit_enrollment', compact('class', 'enrollment_lists', 'enrollment'));
    }
}
