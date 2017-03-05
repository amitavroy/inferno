<?php
/**
 * Created by PhpStorm.
 * User: amitavroy
 * Date: 03/03/17
 * Time: 9:53 AM
 */

namespace App\Http\Controllers\Api;


use App\Events\User\PermissionDeleted;
use App\Events\User\RoleDeleted;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminApiController extends Controller
{
    public function postDeleteRole(Request $request)
    {
        $roleId = $request->input('id');

        if ($roleId == 1 || $roleId == 2) {
            abort(403, 'You cannot edit this role.');
        }

        // this is only done to get the role name
        $role = Role::find($roleId);

        DB::table('roles')->where('id', $roleId)->delete();

        event(new RoleDeleted($role));
        
        return response(['data' => 'Role was deleted'], 200);
    }
    
    public function postDeletePermission(Request $request)
    {
        $permId = $request->input('id');

        // this is only done to get the role name
        $permission = Permission::find($permId);

        DB::table('permissions')->where('id', $permId)->delete();

        event(new PermissionDeleted($permission));

        return response(['data' => 'Permission was deleted.'], 200);
    }
}