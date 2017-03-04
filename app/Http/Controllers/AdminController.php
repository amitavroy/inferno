<?php

namespace App\Http\Controllers;

use App\Events\User\RoleCreated;
use App\Http\Requests\EditRoleRequest;
use App\Http\Requests\SaveRoleRequest;
use App\Http\Requests\SettingAddRequest;
use App\User;
use Illuminate\Http\Request;
use Setting;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{

    public function getConfigPage()
    {
        return view('adminlte.pages.admin.config');
    }

    public function getUserActivationPending()
    {
        $users = User::with('activation_token')
            ->where('active', 0)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('adminlte.pages.admin.user-activation-pending', compact('users'));
    }

    /**
     * Getting settings page.
     *
     * @return $this
     */
    public function getSettingsPage()
    {
        $settings = Setting::all();

        return view('adminlte.pages.settings')->with('settings', $settings);
    }

    public function postHandleSettingsPageSave(Request $request)
    {
        $settings = $request->input('setting');

        foreach ($settings as $key => $value) {
            if ($value === "1") {
                $value = true;
            }
            if ($value === "0") {
                $value = false;
            }
            Setting::set($key, $value);
        }

        Setting::save();
        flash('Settings are now saved.');
        return redirect()->back();
    }

    public function postHandleSettingsPageAdd(SettingAddRequest $request)
    {
        $key = $request->input('name');
        $value = $request->input('value');

        if ($value === "1") {
            $value = true;
        }
        if ($value === "0") {
            $value = false;
        }

        Setting::set($key, $value);
        Setting::save();

        flash('The new setting is now added.');
        return redirect()->back();
    }

    /**
     * Get the page to see the list of roles and also the form to add a new role.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getManageRoles()
    {
        $roles = Role::orderBy('id', 'asc')->paginate(10);
        return view('adminlte.pages.admin.manage-roles', compact('roles'));
    }

    public function postSaveRoles(SaveRoleRequest $request)
    {
        $role = Role::create(['name' => $request->input('name')]);
        event(new RoleCreated($role));
        flash('Added a new Role');
        return redirect()->back();
    }

    /**
     * Get the edit role page.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getEditRole($id)
    {
        $role = Role::find($id);

        return view('adminlte.pages.admin.role-edit', compact('role'));
    }

    public function postUpdateRole(SaveRoleRequest $request)
    {
        $roleId = $request->input('id');

        if ($roleId == 1 || $roleId == 2) {
            abort(403, 'You cannot edit this role.');
        }

        $role = Role::find($request->input('id'));
        $role->name = $request->input('name');
        $role->save();

        flash('Role was updated');
        return redirect()->back();
    }
}
