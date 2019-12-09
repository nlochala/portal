<?php

namespace App\Http\Controllers;

use App\Helpers\DatabaseHelpers;
use Exception;
use App\GradeScale;
use App\Helpers\Helpers;
use App\GradeScalePercentage;
use App\Helpers\FieldValidation;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\StoreGradeScalePercentageRequest;

class GradeScalePercentageAjaxController extends Controller
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
        $this->request = new StoreGradeScalePercentageRequest();
        $this->eagerLoad = ['standard'];
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
     * @param GradeScale $grade_scale
     * @return GradeScalePercentage[]|Collection
     */
    public function ajaxShow(GradeScale $grade_scale)
    {
        return $grade_scale->items()->with('standard')->get();
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

            // EDIT THE GIVEN GradeScalePercentage
            if ($action == 'edit') {
                if ($percentage = $this->update(GradeScalePercentage::find($id), $form_data)) {
                    $return_array['data'][] = $percentage->load($this->eagerLoad);
                }
            }
            // CREATE THE GradeScalePercentage
            if ($action == 'create') {
                $percentage = $this->store($data[$id]);
                $return_array['data'][] = $percentage->load($this->eagerLoad);
            }
        }

        if ($action == 'remove') {
            foreach ($data as $id => $form_data) {
                $this->destroy(GradeScalePercentage::find($id));
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
     * Store the new percentage.
     *
     * @param $values
     * @return bool
     */
    public function store($values)
    {
        $values = DatabaseHelpers::dbAddAudit($values);

        return $this->attemptAction(GradeScalePercentage::create($values), 'percentage', 'create');
    }

    /**
     * Update the given model.
     *
     * @param GradeScalePercentage $percentage
     * @param $values
     * @return GradeScalePercentage|mixed|void
     */
    public function update(GradeScalePercentage $percentage, $values)
    {
        $percentage = DatabaseHelpers::dbAddAudit($percentage);
        $this->attemptAction($percentage->update($values), 'percentage', 'update');

        return $percentage;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param GradeScalePercentage $percentage
     * @return void
     */
    public function destroy(GradeScalePercentage $percentage)
    {
        if ($percentage->is_protected) {
            $this->attemptAction(false, 'percentage', 'delete', 'Can not delete. This item is protected.');

            return;
        }

        $percentage = DatabaseHelpers::dbAddAudit($percentage);
        $this->attemptAction($percentage->delete(), 'percentage', 'delete');
    }
}
