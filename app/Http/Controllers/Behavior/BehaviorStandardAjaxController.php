<?php

namespace App\Http\Controllers;

use Exception;
use App\BehaviorStandard;
use App\Helpers\FieldValidation;
use App\Helpers\DatabaseHelpers;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\StoreBehaviorStandardRequest;

class BehaviorStandardAjaxController extends Controller
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
        $this->request = new StoreBehaviorStandardRequest();
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
     * @return BehaviorStandard[]|Collection
     */
    public function ajaxShow()
    {
        return BehaviorStandard::with($this->eagerLoad)->get();
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

        if ($action == 'remove') {
            foreach ($data as $id => $form_data) {
                $this->destroy(BehaviorStandard::find($id));
            }

            return $return_array;
        }

        foreach ($data as $id => $form_data) {
            $this->validation->checkForm($this->request, $form_data);

            if ($errors = $this->validation->hasErrors()) {
                return $errors;
            }

            // EDIT THE GIVEN BehaviorStandard
            if ($action == 'edit') {
                if ($standard = $this->update(BehaviorStandard::find($id), $form_data)) {
                    $return_array['data'][] = $standard->load($this->eagerLoad);
                }
            }
            // CREATE THE BehaviorStandard
            if ($action == 'create') {
                if ($standard = $this->store($data[$id])) {
                    $return_array['data'][] = $standard->load($this->eagerLoad);
                }
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
        $values = DatabaseHelpers::dbAddAudit($values);

        return $this->attemptAction(BehaviorStandard::create($values), 'standard', 'create');
    }

    /**
     * Update the given model.
     *
     * @param BehaviorStandard $standard
     * @param $values
     * @return BehaviorStandard|mixed|void
     */
    public function update(BehaviorStandard $standard, $values)
    {
        $standard = DatabaseHelpers::dbAddAudit($standard);
        $this->attemptAction($standard->update($values), 'standard', 'update');

        return $standard;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param BehaviorStandard $standard
     * @return void
     */
    public function destroy(BehaviorStandard $standard)
    {
        if ($standard->is_protected) {
            $this->attemptAction(false, 'standard', 'delete',
                'Can not delete. This standard is protected.');
            return;
        }

        $standard = DatabaseHelpers::dbAddAudit($standard);
        $this->attemptAction($standard->delete(), 'standard', 'delete');
    }
}
