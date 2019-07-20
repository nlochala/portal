<?php

namespace App\Http\Controllers;

use Exception;
use App\Quarter;
use App\Helpers\Helpers;
use App\Helpers\FieldValidation;
use App\Http\Requests\StoreQuarterRequest;
use Illuminate\Database\Eloquent\Collection;

class QuarterAjaxController extends Controller
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
        $this->request = new StoreQuarterRequest();
        $this->eagerLoad = ['year'];
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
     * @return Quarter[]|Collection
     */
    public function ajaxShow()
    {
        return Quarter::with($this->eagerLoad)->get();
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

            // EDIT THE GIVEN Quarter
            if ($action === 'edit') {
                if ($quarter = $this->update(Quarter::find($id), $form_data)) {
                    $return_array['data'][] = $quarter->load($this->eagerLoad);
                }
            }
            // CREATE THE Quarter
            if ($action === 'create') {
                $quarter = $this->store($data[$id]);
                $return_array['data'][] = $quarter->load($this->eagerLoad);
            }
        }

        if ($action === 'remove') {
            foreach ($data as $id => $form_data) {
                $this->destroy(Quarter::find($id));
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
     * Store the new quarter.
     *
     * @param $values
     * @return bool
     */
    public function store($values)
    {
        $values = Helpers::dbAddAudit($values);
        $values['name'] = Quarter::getName($values['name']);

        return $this->attemptAction(Quarter::create($values), 'quarter', 'create');
    }

    /**
     * Update the given model.
     *
     * @param Quarter $quarter
     * @param $values
     * @return Quarter|mixed|void
     */
    public function update(Quarter $quarter, $values)
    {
        $quarter = Helpers::dbAddAudit($quarter);
        $values['name'] = Quarter::getName($values['name']);

        $this->attemptAction($quarter->update($values), 'quarter', 'update');

        return $quarter;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Quarter $quarter
     * @return void
     */
    public function destroy(Quarter $quarter)
    {
        $quarter = Helpers::dbAddAudit($quarter);
        $this->attemptAction($quarter->delete(), 'quarter', 'delete');
    }
}
