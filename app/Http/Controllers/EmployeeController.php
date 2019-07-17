<?php

namespace App\Http\Controllers;

use App\Person;
use App\Employee;
use App\EmployeeStatus;
use App\Helpers\Helpers;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\EmployeeClassification;
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
        $values = Helpers::dbAddAudit(request()->all());
        $values['gender'] = Person::getGender($values['gender']);
        $values['title'] = Person::getTitle($values['title']);
        $person = Person::create($values);

        $employee_values['person_id'] = $person->id;
        $employee_values['employee_status_id'] = $values['employee_status_id'];
        $employee_values['employee_classification_id'] = $values['employee_classification_id'];
        $employee_values['start_date'] = $values['start_date'];
        $employee_values['end_date'] = $values['end_date'];

        $values = Helpers::dbAddAudit($employee_values);
        $employee = Employee::create($values);

        Helpers::flash($employee, 'employee');

        if ($employee) {
            $employee->searchable();
            return redirect()->to('employee/'.$employee->uuid.'/profile');
        }

        return redirect()->back()->withInput();
    }
}
