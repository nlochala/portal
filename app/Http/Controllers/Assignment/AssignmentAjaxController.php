<?php

namespace App\Http\Controllers;

use App\Helpers\DatabaseHelpers;
use Exception;
use App\Quarter;
use App\Assignment;
use App\CourseClass;
use App\Helpers\Helpers;
use App\Helpers\FieldValidation;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\StoreAssignmentRequest;

class AssignmentAjaxController extends Controller
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
        $this->request = new StoreAssignmentRequest();
        $this->eagerLoad = ['type', 'quarter'];
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
     * @param CourseClass $class
     * @param Quarter $quarter
     * @return Assignment[]|Collection
     */
    public function ajaxShow(CourseClass $class, Quarter $quarter)
    {
        return Assignment::courseClass($class->id)->quarter($quarter->id)->with($this->eagerLoad)->get();
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

            // EDIT THE GIVEN Assignment
            if ($action == 'edit') {
                if ($assignment = $this->update(Assignment::find($id), $form_data)) {
                    $return_array['data'][] = $assignment->load($this->eagerLoad);
                }
            }
            // CREATE THE Assignment
            if ($action == 'create') {
                $assignment = $this->store($data[$id]);
                $return_array['data'][] = $assignment->load($this->eagerLoad);
            }
        }

        if ($action == 'remove') {
            foreach ($data as $id => $form_data) {
                $this->destroy(Assignment::find($id));
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
     * Store the new assignment.
     *
     * @param $values
     * @return bool
     */
    public function store($values)
    {
        $values = DatabaseHelpers::dbAddAudit($values);

        return $this->attemptAction(Assignment::create($values), 'assignment', 'create');
    }

    /**
     * Update the given model.
     *
     * @param Assignment $assignment
     * @param $values
     * @return Assignment|mixed|void
     */
    public function update(Assignment $assignment, $values)
    {
        $assignment = DatabaseHelpers::dbAddAudit($assignment);
        $this->attemptAction($assignment->update($values), 'assignment', 'update');

        return $assignment;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Assignment $assignment
     * @return void
     */
    public function destroy(Assignment $assignment)
    {
        $assignment = DatabaseHelpers::dbAddAudit($assignment);

        if (! $assignment->grades->isEmpty()) {
            $message = 'Can not delete the assignment because grades have already been taken on it.';
            $this->attemptAction(false, 'assignment', 'delete', $message);
        } else {
            $this->attemptAction($assignment->delete(), 'assignment', 'delete');
        }
    }
}
