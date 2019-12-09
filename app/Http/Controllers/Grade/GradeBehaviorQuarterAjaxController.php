<?php

namespace App\Http\Controllers;

use App\Helpers\DatabaseHelpers;
use Exception;
use App\Quarter;
use App\Helpers\Helpers;
use App\GradeBehaviorQuarter;
use App\Helpers\FieldValidation;
use App\Http\Requests\StoreDefaultRequest;
use Illuminate\Database\Eloquent\Collection;

class GradeBehaviorQuarterAjaxController extends Controller
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
        $this->request = new StoreDefaultRequest();
        $this->eagerLoad = ['approvedBy.person', 'createdBy', 'student.person', 'student.gradeLevel', 'item'];
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
     * @param Quarter $quarter
     * @return GradeBehaviorQuarter[]|Collection
     */
    public function ajaxShow(Quarter $quarter)
    {
        return GradeBehaviorQuarter::with($this->eagerLoad)->where('quarter_id', $quarter->id)->get();
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

            // EDIT THE GIVEN GradeBehaviorQuarter
            if ($action == 'edit') {
                if ($item = $this->update(GradeBehaviorQuarter::find($id), $form_data)) {
                    $return_array['data'][] = $item->load($this->eagerLoad);
                }
            }
            // CREATE THE GradeBehaviorQuarter
            if ($action == 'create') {
                if ($item = $this->store($data[$id])) {
                    $return_array['data'][] = $item->load($this->eagerLoad);
                }
            }
        }

        if ($action == 'remove') {
            foreach ($data as $id => $form_data) {
                $this->destroy(GradeBehaviorQuarter::find($id));
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
     * Store the new item.
     *
     * @param $values
     * @return bool
     */
    public function store($values)
    {
        $values = DatabaseHelpers::dbAddAudit($values);

        return $this->attemptAction(GradeBehaviorQuarter::create($values), 'item', 'create');
    }

    /**
     * Update the given model.
     *
     * @param GradeBehaviorQuarter $item
     * @param $values
     * @return GradeBehaviorQuarter|mixed|void
     */
    public function update(GradeBehaviorQuarter $item, $values)
    {
        $item = DatabaseHelpers::dbAddAudit($item);
        if (isset($values['is_approved']) && $values['is_approved'] === '1') {
            $values['is_approved'] = true;
            $values['approved_on'] = now();
            $values['approved_by_employee_id'] = auth()->user()->person->employee->id;
        } else {
            $values['is_approved'] = false;
            $values['approved_on'] = null;
            $values['approved_by_employee_id'] = null;
        }
        $this->attemptAction($item->update($values), 'item', 'update');

        return $item;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param GradeBehaviorQuarter $item
     * @return void
     */
    public function destroy(GradeBehaviorQuarter $item)
    {
        $item = DatabaseHelpers::dbAddAudit($item);
        $this->attemptAction($item->delete(), 'item', 'delete');
    }
}
