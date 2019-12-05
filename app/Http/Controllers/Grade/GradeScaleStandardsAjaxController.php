<?php

namespace App\Http\Controllers;

use Exception;
use App\GradeScale;
use App\Helpers\Helpers;
use App\GradeScaleStandard;
use App\Helpers\FieldValidation;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\StoreGradeScaleStandardRequest;

class GradeScaleStandardsAjaxController extends Controller
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
        $this->request = new StoreGradeScaleStandardRequest();
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
     * @param GradeScale $gradeScale
     * @return GradeScaleStandard[]|Collection
     */
    public function ajaxShow(GradeScale $gradeScale)
    {
        return $gradeScale->items;
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

            // EDIT THE GIVEN GradeScaleStandard
            if ($action == 'edit') {
                if ($standard = $this->update(GradeScaleStandard::find($id), $form_data)) {
                    $return_array['data'][] = $standard->load($this->eagerLoad);
                }
            }
            // CREATE THE GradeScaleStandard
            if ($action == 'create') {
                $standard = $this->store($data[$id]);
                $return_array['data'][] = $standard->load($this->eagerLoad);
            }
        }

        if ($action == 'remove') {
            foreach ($data as $id => $form_data) {
                $this->destroy(GradeScaleStandard::find($id));
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
     * Store the new standard.
     *
     * @param $values
     * @return bool
     */
    public function store($values)
    {
        $values = Helpers::dbAddAudit($values);

        return $this->attemptAction(GradeScaleStandard::create($values), 'standard', 'create');
    }

    /**
     * Update the given model.
     *
     * @param GradeScaleStandard $standard
     * @param $values
     * @return GradeScaleStandard|mixed|void
     */
    public function update(GradeScaleStandard $standard, $values)
    {
        $standard = Helpers::dbAddAudit($standard);
        $this->attemptAction($standard->update($values), 'standard', 'update');

        return $standard;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param GradeScaleStandard $standard
     * @return void
     */
    public function destroy(GradeScaleStandard $standard)
    {
        if ($standard->is_protected) {
            $this->attemptAction(false, 'percentage', 'delete', 'Can not delete. This item is protected.');

            return;
        }

        $standard = Helpers::dbAddAudit($standard);
        $this->attemptAction($standard->delete(), 'standard', 'delete');
    }
}
