<?php

namespace App\Http\Controllers;

use App\Helpers\DatabaseHelpers;
use Exception;
use App\Permission;
use App\Helpers\Helpers;
use App\Helpers\FieldValidation;
use App\Http\Requests\StorePermissionRequest;
use Illuminate\Database\Eloquent\Collection;

class PermissionAjaxController extends Controller
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
        $this->request = new StorePermissionRequest();
        $this->eagerLoad = ['roles'];
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
     * @return Permission[]|Collection
     */
    public function ajaxShow()
    {
        return Permission::with($this->eagerLoad)->get();
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

            // EDIT THE GIVEN Permission
            if ($action == 'edit') {
                if ($permission = $this->update(Permission::find($id), $form_data)) {
                    $return_array['data'][] = $permission->load($this->eagerLoad);
                }
            }
            // CREATE THE Permission
            if ($action == 'create') {
                $permission = $this->store($data[$id]);
                $return_array['data'][] = $permission->load($this->eagerLoad);
            }
        }

        if ($action == 'remove') {
            foreach ($data as $id => $form_data) {
                $this->destroy(Permission::find($id));
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
     * Store the new permission.
     *
     * @param $values
     * @return bool
     */
    public function store($values)
    {
        $values = DatabaseHelpers::dbAddAudit($values);

        return $this->attemptAction(Permission::create($values), 'permission', 'create');
    }

    /**
     * Update the given model.
     *
     * @param Permission $permission
     * @param $values
     * @return Permission|mixed|void
     */
    public function update(Permission $permission, $values)
    {
        $permission = DatabaseHelpers::dbAddAudit($permission);
        $this->attemptAction($permission->update($values), 'permission', 'update');

        return $permission;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Permission $permission
     * @return void
     */
    public function destroy(Permission $permission)
    {
        $permission = DatabaseHelpers::dbAddAudit($permission);
        $this->attemptAction($permission->delete(), 'permission', 'delete');
    }
}
