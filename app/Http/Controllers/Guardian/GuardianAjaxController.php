<?php

namespace App\Http\Controllers;

use Exception;
use App\Guardian;
use App\Helpers\Helpers;
use App\Helpers\FieldValidation;
use App\Http\Requests\StoreGuardianRequest;
use Illuminate\Database\Eloquent\Collection;

class GuardianAjaxController extends Controller
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
        $this->request = new StoreGuardianRequest();
        $this->eagerLoad = ['person.user', 'person.phones.phoneType', 'person.phones.country', 'type', 'family'];
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
     * @return Guardian[]|Collection
     */
    public function ajaxShow()
    {
        return Guardian::with($this->eagerLoad)->get();
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

            // EDIT THE GIVEN Guardian
            if ($action == 'edit') {
                if ($guardian = $this->update(Guardian::find($id), $form_data)) {
                    $return_array['data'][] = $guardian->load($this->eagerLoad);
                }
            }
            // CREATE THE Guardian
            if ($action == 'create') {
                $guardian = $this->store($data[$id]);
                $return_array['data'][] = $guardian->load($this->eagerLoad);
            }
        }

        if ($action == 'remove') {
            foreach ($data as $id => $form_data) {
                $this->destroy(Guardian::find($id));
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
     * Store the new guardian.
     *
     * @param $values
     * @return bool
     */
    public function store($values)
    {
        $values = Helpers::dbAddAudit($values);

        return $this->attemptAction(Guardian::create($values), 'guardian', 'create');
    }

    /**
     * Update the given model.
     *
     * @param Guardian $guardian
     * @param $values
     * @return Guardian|mixed|void
     */
    public function update(Guardian $guardian, $values)
    {
        $guardian = Helpers::dbAddAudit($guardian);
        $this->attemptAction($guardian->update($values), 'guardian', 'update');

        return $guardian;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Guardian $guardian
     * @return void
     */
    public function destroy(Guardian $guardian)
    {
        $guardian = Helpers::dbAddAudit($guardian);
        $this->attemptAction($guardian->delete(), 'guardian', 'delete');
    }
}
