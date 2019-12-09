<?php

namespace App\Http\Controllers;

use App\Helpers\DatabaseHelpers;
use Exception;
use App\Department;
use App\Helpers\Helpers;
use App\Helpers\FieldValidation;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\StoreDepartmentRequest;

class DepartmentAjaxController extends Controller
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
        $this->middleware('auth')->except('ajaxShow');
        $this->validation = new FieldValidation();
        $this->errors = false;
        $this->request = new StoreDepartmentRequest();
        $this->eagerLoad = [];
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
     * @return Department[]|Collection
     */
    public function ajaxShow()
    {
        return Department::with($this->eagerLoad)->get();
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

            // EDIT THE GIVEN Department
            if ($action == 'edit') {
                if ($department = $this->update(Department::find($id), $form_data)) {
                    $return_array['data'][] = $department->load($this->eagerLoad);
                }
            }
            // CREATE THE Department
            if ($action == 'create') {
                $department = $this->store($data[$id]);
                $return_array['data'][] = $department->load($this->eagerLoad);
            }
        }

        if ($action == 'remove') {
            foreach ($data as $id => $form_data) {
                $this->destroy(Department::find($id));
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
     * Store the new department.
     *
     * @param $values
     * @return bool
     */
    public function store($values)
    {
        $values = DatabaseHelpers::dbAddAudit($values);

        return $this->attemptAction(Department::create($values), 'department', 'create');
    }

    /**
     * Update the given model.
     *
     * @param Department $department
     * @param $values
     * @return Department|mixed|void
     */
    public function update(Department $department, $values)
    {
        $department = DatabaseHelpers::dbAddAudit($department);
        $this->attemptAction($department->update($values), 'department', 'update');

        return $department;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Department $department
     * @return void
     */
    public function destroy(Department $department)
    {
        if ($department->is_protected) {
            $this->attemptAction(false, 'department', 'delete', 'Can not delete. This department is protected.');
            return;
        }

        $department = DatabaseHelpers::dbAddAudit($department);
        $this->attemptAction($department->delete(), 'department', 'delete');
    }
}
