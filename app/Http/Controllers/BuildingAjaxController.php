<?php

namespace App\Http\Controllers;

use Exception;
use App\Building;
use App\Helpers\Helpers;
use App\Helpers\FieldValidation;
use App\Http\Requests\StoreBuildingRequest;
use Illuminate\Database\Eloquent\Collection;

class BuildingAjaxController extends Controller
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
        $this->request = new StoreBuildingRequest();
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
     * @return Building[]|Collection
     */
    public function ajaxShow()
    {
        return Building::with($this->eagerLoad)->get();
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

            // EDIT THE GIVEN Building
            if ($action == 'edit') {
                if ($building = $this->update(Building::find($id), $form_data)) {
                    $return_array['data'][] = $building->load($this->eagerLoad);
                }
            }
            // CREATE THE Building
            if ($action == 'create') {
                $building = $this->store($data[$id]);
                $return_array['data'][] = $building->load($this->eagerLoad);
            }
        }

        if ($action == 'remove') {
            foreach ($data as $id => $form_data) {
                $this->destroy(Building::find($id));
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
     * Store the new building.
     *
     * @param $values
     * @return bool
     */
    public function store($values)
    {
        $values = Helpers::dbAddAudit($values);

        return $this->attemptAction(Building::create($values), 'building', 'create');
    }

    /**
     * Update the given model.
     *
     * @param Building $building
     * @param $values
     * @return Building|mixed|void
     */
    public function update(Building $building, $values)
    {
        $building = Helpers::dbAddAudit($building);
        $this->attemptAction($building->update($values), 'building', 'update');

        return $building;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Building $building
     * @return void
     */
    public function destroy(Building $building)
    {
        if ($building->is_protected) {
            $this->attemptAction(false, 'building', 'delete', 'Can not delete. This building is protected.');

            return;
        }

        $building = Helpers::dbAddAudit($building);
        $this->attemptAction($building->delete(), 'building', 'delete');
    }
}
