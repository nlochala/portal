<?php

namespace App\Http\Controllers;

use App\Helpers\DatabaseHelpers;
use Exception;
use App\Family;
use App\Helpers\Helpers;
use App\Helpers\FieldValidation;
use Illuminate\Database\Eloquent\Collection;

class FamilyAjaxController extends Controller
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
        $this->eagerLoad = ['students.person', 'guardians.person'];
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
     * @return Family[]|Collection
     */
    public function ajaxShow()
    {
        return Family::with($this->eagerLoad)->get();
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

            // EDIT THE GIVEN Family
            if ($action == 'edit') {
                if ($family = $this->update(Family::find($id), $form_data)) {
                    $return_array['data'][] = $family->load($this->eagerLoad);
                }
            }
            // CREATE THE Family
            if ($action == 'create') {
                $family = $this->store($data[$id]);
                $return_array['data'][] = $family->load($this->eagerLoad);
            }
        }

        if ($action == 'remove') {
            foreach ($data as $id => $form_data) {
                $this->destroy(Family::find($id));
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
     * Store the new family.
     *
     * @param $values
     * @return bool
     */
    public function store($values)
    {
        $values = DatabaseHelpers::dbAddAudit($values);

        return $this->attemptAction(Family::create($values), 'family', 'create');
    }

    /**
     * Update the given model.
     *
     * @param Family $family
     * @param $values
     * @return Family|mixed|void
     */
    public function update(Family $family, $values)
    {
        $family = DatabaseHelpers::dbAddAudit($family);
        $this->attemptAction($family->update($values), 'family', 'update');

        return $family;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Family $family
     * @return void
     */
    public function destroy(Family $family)
    {
        $family = DatabaseHelpers::dbAddAudit($family);
        $this->attemptAction($family->delete(), 'family', 'delete');
    }
}
