<?php

namespace App\Http\Controllers;

use Exception;
use App\CourseClass;
use App\Helpers\Helpers;
use App\Helpers\FieldValidation;
use App\Http\Requests\StoreClassRequest;
use Illuminate\Database\Eloquent\Collection;

class ClassAjaxController extends Controller
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
        $this->request = new StoreClassRequest();
        $this->eagerLoad = [
            'course.gradeLevels',
            'primaryEmployee.person',
            'secondaryEmployee.person',
            'taEmployee.person',
            'room.building',
            'year',
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
     * @return CourseClass[]|Collection
     */
    public function ajaxShow()
    {
        return CourseClass::with($this->eagerLoad)->get();
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

            // EDIT THE GIVEN CourseClass
            if ($action == 'edit') {
                if ($class = $this->update(CourseClass::find($id), $form_data)) {
                    $return_array['data'][] = $class->load($this->eagerLoad);
                }
            }
            // CREATE THE CourseClass
            if ($action == 'create') {
                $class = $this->store($data[$id]);
                $return_array['data'][] = $class->load($this->eagerLoad);
            }
        }

        if ($action == 'remove') {
            foreach ($data as $id => $form_data) {
                $this->destroy(CourseClass::find($id));
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
     * Store the new class.
     *
     * @param $values
     * @return bool
     */
    public function store($values)
    {
        $values = Helpers::dbAddAudit($values);

        return $this->attemptAction(CourseClass::create($values), 'class', 'create');
    }

    /**
     * Update the given model.
     *
     * @param CourseClass $class
     * @param $values
     * @return CourseClass|mixed|void
     */
    public function update(CourseClass $class, $values)
    {
        $class = Helpers::dbAddAudit($class);
        $this->attemptAction($class->update($values), 'class', 'update');

        return $class;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param CourseClass $class
     * @return void
     */
    public function destroy(CourseClass $class)
    {
        $class = Helpers::dbAddAudit($class);
        $this->attemptAction($class->delete(), 'class', 'delete');
    }
}
