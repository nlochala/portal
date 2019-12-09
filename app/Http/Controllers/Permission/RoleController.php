<?php

namespace App\Http\Controllers;

use App\Helpers\DatabaseHelpers;
use App\Helpers\ViewHelpers;
use App\Role;
use App\Permission;
use App\Helpers\Helpers;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;

class RoleController extends Controller
{
    /**
     * Require users to have been authenticated before reaching this page.
     *
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return Factory|View
     */
    public function index()
    {
        return view('role.index');
    }

    /**
     * Display the role.
     *
     * @param Role $role
     * @return Factory|View
     */
    public function show(Role $role)
    {
        $role->load('permissions', 'users.person.employee');
        $permission_ids = $role->permissions->pluck('id')->toArray();
        $permissions_list = Permission::permissionsList();

        return view('role.show', compact('role', 'permission_ids', 'permissions_list'));
    }

    /**
     * Store the new role.
     *
     * @return RedirectResponse
     */
    public function store()
    {
        $values = DatabaseHelpers::dbAddAudit(request()->all());
       ViewHelpers::flash(Role::create($values), 'role');

        return redirect()->back();
    }

    /**
     * Update the role's overview.
     *
     * @param Role $role
     * @return RedirectResponse
     */
    public function updateOverview(Role $role)
    {
        $values = DatabaseHelpers::dbAddAudit(request()->all());
       ViewHelpers::flash($role->update($values), 'role', 'updated');

        return redirect()->back();
    }

    /**
     * Update the permissions associated with a given role.
     *
     * @param Role $role
     * @return RedirectResponse
     */
    public function updatePermissions(Role $role)
    {
        $permission_ids = isset(request()->all()['permissions'])
            ? request()->all()['permissions']
            : [];

        $role = DatabaseHelpers::dbAddAudit($role);
        $role->save();

       ViewHelpers::flash($role->permissions()->sync($permission_ids), 'role permissions', 'updated');

        return redirect()->back();
    }

    /**
     * Archive the given role.
     *
     * @param Role $role
     * @return RedirectResponse
     */
    public function archive(Role $role)
    {
        $role = DatabaseHelpers::dbAddAudit($role);
        $role->save();
       ViewHelpers::flash($role->delete(), 'role', 'archived');

        return redirect()->back();
    }
}
