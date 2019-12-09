<?php

namespace App\Http\Controllers;

use App\Helpers\DatabaseHelpers;
use App\Helpers\ViewHelpers;
use App\Person;
use App\Employee;
use App\CourseClass;
use App\EmployeeStatus;
use App\Helpers\Helpers;
use Illuminate\View\View;
use App\EmployeeClassification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;

class EmployeeController extends Controller
{
    /**
     * Require users to have been authenticated before reaching this page.
     *
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->except('ajaxShow');
    }

    /**
     * Show the dashboard for the employee.
     *
     * @param Employee $employee
     * @return Factory|View
     */
    public function dashboard(Employee $employee)
    {
        $employee->load(
            'status',
            'classification',
            'positions.type',
            'positions.school',
            'positions.supervisor',
            'person.user.adGroups'
        );

        $classes = CourseClass::where('primary_employee_id', '=', $employee->id)
            ->orWhere('secondary_employee_id', '=', $employee->id)
            ->orWhere('ta_employee_id', '=', $employee->id)
            ->get();

        return view('employee.dashboard', compact('employee', 'classes'));
    }

    /**
     * Display an index of all employees.
     *
     * @return Factory|View
     */
    public function index()
    {
        $title_dropdown = Person::$titleDropdown;
        $gender_dropdown = Person::$genderRadio;
        $classifications = EmployeeClassification::getDropdown();
        $statuses = EmployeeStatus::getDropdown();

        return view('employee.index', compact(
            'gender_dropdown',
            'title_dropdown',
            'classifications',
            'statuses'
        ));
    }

    /**
     * Store a new employee.
     *
     * @return RedirectResponse
     */
    public function storeNewEmployee()
    {
        $values = DatabaseHelpers::dbAddAudit(request()->all());
        $values['gender'] = Person::getGender($values['gender']);
        $values['title'] = Person::getTitle($values['title']);
        $person = Person::create($values);

        $employee_values['person_id'] = $person->id;
        $employee_values['employee_status_id'] = $values['employee_status_id'];
        $employee_values['employee_classification_id'] = $values['employee_classification_id'];
        $employee_values['start_date'] = $values['start_date'];
        $employee_values['end_date'] = $values['end_date'];

        $values = DatabaseHelpers::dbAddAudit($employee_values);
        $employee = Employee::create($values);

       ViewHelpers::flash($employee, 'employee');

        if ($employee) {
            $employee->searchable();

            return redirect()->to('employee/'.$employee->uuid.'/profile');
        }

        return redirect()->back()->withInput();
    }
}
