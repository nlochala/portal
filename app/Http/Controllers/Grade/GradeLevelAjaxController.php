<?php

namespace App\Http\Controllers;

use Exception;
use App\GradeLevel;
use App\Helpers\Helpers;
use App\Helpers\FieldValidation;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\StoreGradeLevelRequest;

class GradeLevelAjaxController extends Controller
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
        $this->request = new StoreGradeLevelRequest();
        $this->eagerLoad = ['year', 'school'];
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
    public function attemptAction($result, $item = 'school grade_level or position', $action = 'update or delete', $custom_message = null)
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
     * @return GradeLevel[]|Collection
     */
    public function ajaxShow()
    {
        return GradeLevel::with($this->eagerLoad)->get();
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

            // EDIT THE GIVEN GradeLevel
            if ($action == 'edit') {
                if ($grade_level = $this->update(GradeLevel::find($id), $form_data)) {
                    $return_array['data'][] = $grade_level->load($this->eagerLoad);
                }
            }
            // CREATE THE GradeLevel
            if ($action == 'create') {
                $grade_level = $this->store($data[$id]);
                $return_array['data'][] = $grade_level->load($this->eagerLoad);
            }
        }

        if ($action == 'remove') {
            foreach ($data as $id => $form_data) {
                $this->destroy(GradeLevel::find($id));
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
     * Store the new grade_level.
     *
     * @param $values
     * @return bool
     */
    public function store($values)
    {
        $values = Helpers::dbAddAudit($values);

        return $this->attemptAction(GradeLevel::create($values), 'grade_level', 'create');
    }

    /**
     * Update the given model.
     *
     * @param GradeLevel $grade_level
     * @param $values
     * @return GradeLevel|mixed|void
     */
    public function update(GradeLevel $grade_level, $values)
    {
        $grade_level = Helpers::dbAddAudit($grade_level);
        $this->attemptAction($grade_level->update($values), 'grade_level', 'update');

        return $grade_level;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param GradeLevel $grade_level
     * @return void
     */
    public function destroy(GradeLevel $grade_level)
    {
        if ($grade_level->is_protected) {
            $this->attemptAction(false, 'grade_level', 'delete', 'Can not delete. This grade level is protected.');

            return;
        }

        $grade_level = Helpers::dbAddAudit($grade_level);
        $this->attemptAction($grade_level->delete(), 'grade_level', 'delete');
    }
}
