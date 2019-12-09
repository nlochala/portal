<?php

namespace App\Http\Controllers;

use App\Helpers\DatabaseHelpers;
use Exception;
use App\Employee;
use App\Helpers\Helpers;
use App\Helpers\FieldValidation;
use App\Http\Requests\StoreEmployeeRequest;
use Illuminate\Database\Eloquent\Collection;

class EmployeeAjaxController extends EmployeeController
{
    protected $validation;
    protected $errors;
    protected $request;
    protected $eagerLoad;

    /**
     * Require users to have been authenticated before reaching this page.
     *
     * UserController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->validation = new FieldValidation();
        $this->errors = false;
        $this->request = new StoreEmployeeRequest();
        $this->eagerLoad = [
            'person.user',
            'person.phones.phoneType',
            'person.phones.country',
            'classification',
            'status',
        ];
    }

    /**
     * Add an error if needed.
     *
     * @param bool $result
     * @param string $item
     * @param string $action
     * @param null $custom_message
     * @return bool|void
     */
    public function attemptAction($result, $item = 'year', $action = 'update', $custom_message = null)
    {
        if ($result) {
            return $result;
        }

        if ($custom_message) {
            $this->errors[] = $custom_message;

            return;
        }

        $this->errors[] = "Could not $action this $item. Please try again.";
    }

    /*
        |--------------------------------------------------------------------------
        | AJAX METHODS
        |--------------------------------------------------------------------------
    */

    /**
     * This returns a json formatted array for the table.
     *
     * @return Employee[]|Collection
     */
    public function ajaxShow()
    {
        return Employee::with($this->eagerLoad)->get();
    }

    /**
     * Take the given arrays and specified actions and pass them to the CRUD methods
     * below.
     * @return array|bool
     * @throws Exception
     */
    public function ajaxStore()
    {
        $values = request()->all();

        $action = $values['action'];
        $data = $values['data'];
        $return_array = [];

        foreach ($data as $id => $form_data) {
            $this->validation->checkForm($this->request, $form_data);

            if ($errors = $this->validation->hasErrors()) {
                return $errors;
            }

            // EDIT THE GIVEN Employee
            if ($action == 'edit') {
                if ($employee = $this->update(Employee::find($id), $form_data)) {
                    $return_array['data'][] = $employee->load($this->eagerLoad);
                }
            }
            // CREATE THE Employee
            if ($action == 'create') {
                $employee = $this->store($data[$id]);
                $return_array['data'][] = $employee->load($this->eagerLoad);
            }
        }

        if ($action == 'remove') {
            foreach ($data as $id => $form_data) {
                $this->destroy(Employee::find($id));
            }
        }

        if ($this->errors) {
            $return_array['error'] = $this->errors;
        }

        return $return_array;
    }

    /*
        |--------------------------------------------------------------------------
        | CRUD METHODS
        |--------------------------------------------------------------------------
    */

    /**
     * Store the new employee.
     *
     * @param $values
     * @return bool
     */
    public function store($values)
    {
        $values = DatabaseHelpers::dbAddAudit($values);

        return $this->attemptAction(Employee::create($values), 'employee', 'create');
    }

    /**
     * Update the given model.
     *
     * @param Employee $employee
     * @param $values
     * @return Employee|mixed|void
     */
    public function update(Employee $employee, $values)
    {
        $employee = DatabaseHelpers::dbAddAudit($employee);
        $this->attemptAction($employee->update($values), 'employee', 'update');

        return $employee;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Employee $employee
     * @return void
     */
    public function destroy(Employee $employee)
    {
        $employee = DatabaseHelpers::dbAddAudit($employee);
        $this->attemptAction($employee->delete(), 'employee', 'delete');
    }
}
