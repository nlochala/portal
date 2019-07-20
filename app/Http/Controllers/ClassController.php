<?php

namespace App\Http\Controllers;

use App\Room;
use App\Year;
use App\Course;
use App\Employee;
use App\ClassStatus;
use App\CourseClass;
use App\Helpers\Helpers;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ClassController extends Controller
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
     * Show the directory of classes.
     *
     * @return Factory|View
     */
    public function index()
    {
        $employee_dropdown = Employee::getDropdown();
        $course_dropdown = Course::getDropdown('active');
        $room_dropdown = Room::getDropdown();
        $year_dropdown = Year::getDropdown('currentFuture');
        $status_dropdown = ClassStatus::getDropdown();

        return view('class.index', compact(
            'employee_dropdown',
            'course_dropdown',
            'room_dropdown',
            'year_dropdown',
            'status_dropdown'
        ));
    }

    /**
     * Show the class dashboard.
     *
     * @param CourseClass $class
     * @return Factory|View
     */
    public function show(CourseClass $class)
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

        return view('class.show', compact('class'));
    }

    /**
     * Store the newly created class.
     *
     * @return RedirectResponse
     */
    public function store()
    {
        $values = Helpers::dbAddAudit(request()->all());
        $class = CourseClass::create($values);
        Helpers::flash($class, 'class');

        return $class
            ? redirect()->to('class/'.$class->uuid)
            : redirect()->back()->withInput();
    }

    /**
     * Show the update form.
     *
     * @param CourseClass $class
     * @return Factory|View
     */
    public function update(CourseClass $class)
    {
        $employee_dropdown = Employee::getDropdown();
        $course_dropdown = Course::getDropdown('active');
        $room_dropdown = Room::getDropdown();
        $year_dropdown = Year::getDropdown('currentFuture');
        $status_dropdown = ClassStatus::getDropdown();

        return view('class.edit_overview', compact(
            'class',
            'employee_dropdown',
            'course_dropdown',
            'room_dropdown',
            'year_dropdown',
            'status_dropdown'
        ));
    }

    /**
     * Store the updated class.
     *
     * @param CourseClass $class
     * @return RedirectResponse
     */
    public function storeUpdate(CourseClass $class)
    {
        $values = Helpers::dbAddAudit(request()->all());
        $result = $class->update($values);
        Helpers::flash($result, 'class');

        return $result
            ? redirect()->to('class/'.$class->uuid)
            : redirect()->back()->withInput();

    }
}
