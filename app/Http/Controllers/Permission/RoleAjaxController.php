<?php

namespace App\Http\Controllers;

use App\Helpers\DatabaseHelpers;
use Exception;
use App\Role;
use App\Helpers\Helpers;
use App\Helpers\FieldValidation;
use App\Http\Requests\StoreRoleRequest;
use Illuminate\Database\Eloquent\Collection;

class RoleAjaxController extends Controller
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
        $this->request = new StoreRoleRequest();
        $this->eagerLoad = ['permissions', 'users'];
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
     * @return Role[]|Collection
     */
    public function ajaxShow()
    {
        return Role::with($this->eagerLoad)->get();
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

            // EDIT THE GIVEN Role
            if ($action == 'edit') {
                if ($role = $this->update(Role::find($id), $form_data)) {
                    $return_array['data'][] = $role->load($this->eagerLoad);
                }
            }
            // CREATE THE Role
            if ($action == 'create') {
                $role = $this->store($data[$id]);
                $return_array['data'][] = $role->load($this->eagerLoad);
            }
        }

        if ($action == 'remove') {
            foreach ($data as $id => $form_data) {
                $this->destroy(Role::find($id));
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
     * Store the new role.
     *
     * @param $values
     * @return bool
     */
    public function store($values)
    {
        $values = DatabaseHelpers::dbAddAudit($values);

        return $this->attemptAction(Role::create($values), 'role', 'create');
    }

    /**
     * Update the given model.
     *
     * @param Role $role
     * @param $values
     * @return Role|mixed|void
     */
    public function update(Role $role, $values)
    {
        $role = DatabaseHelpers::dbAddAudit($role);
        $this->attemptAction($role->update($values), 'role', 'update');

        return $role;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     * @return void
     */
    public function destroy(Role $role)
    {
        $role = DatabaseHelpers::dbAddAudit($role);
        $this->attemptAction($role->delete(), 'role', 'delete');
    }
}
