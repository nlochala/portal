<?php

namespace App\Http\Controllers;

use Exception;
use App\CourseClass;
use App\AssignmentType;
use App\Helpers\Helpers;
use App\Helpers\FieldValidation;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\StoreAssignmentTypeRequest;

class AssignmentTypeAjaxController extends Controller
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
        $this->request = new StoreAssignmentTypeRequest();
        $this->eagerLoad = ['assignments'];
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
     * @return AssignmentType[]|Collection
     */
    public function ajaxShow(CourseClass $class)
    {
        return AssignmentType::courseClass($class->id)->with($this->eagerLoad)->get();
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

            // EDIT THE GIVEN AssignmentType
            if ($action == 'edit') {
                if ($type = $this->update(AssignmentType::find($id), $form_data)) {
                    $return_array['data'][] = $type->load($this->eagerLoad);
                }
            }
            // CREATE THE AssignmentType
            if ($action == 'create') {
                $type = $this->store($data[$id]);
                $return_array['data'][] = $type->load($this->eagerLoad);
            }
        }

        if ($action == 'remove') {
            foreach ($data as $id => $form_data) {
                $this->destroy(AssignmentType::find($id));
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
     * Store the new type.
     *
     * @param $values
     * @return bool
     */
    public function store($values)
    {
        $values = Helpers::dbAddAudit($values);

        return $this->attemptAction(AssignmentType::create($values), 'type', 'create');
    }

    /**
     * Update the given model.
     *
     * @param AssignmentType $type
     * @param $values
     * @return AssignmentType|mixed|void
     */
    public function update(AssignmentType $type, $values)
    {
        $type = Helpers::dbAddAudit($type);
        $this->attemptAction($type->update($values), 'type', 'update');

        return $type;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param AssignmentType $type
     * @return void
     */
    public function destroy(AssignmentType $type)
    {
        $type = Helpers::dbAddAudit($type);

        $message = 'Could not delete this assignment type. The reason is because there are assignments already created with this type.';
        $message .= 'Please change the assigned type on those assignments and try again.';

        $this->attemptAction($type->assignments->isEmpty(), 'type', 'delete', $message);
        $this->attemptAction($type->delete(), 'type', 'delete');
    }
}
