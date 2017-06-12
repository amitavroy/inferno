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
use App\Services\User\UserImport;
use App\TempTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function importCorrectUsers($id, UserImport $userImport)
    {
        $data = TempTable::where('uuid', $id)->first();

        if (!$data) {
            return response('Cannot find the data', 400);
        }

        if ($data->user_id != Auth::user()->id) {
            return response('Access denied', 403);
        }

        $data = unserialize($data->data);
        $count = count($data);

        $header = [];

        if ($count == 0) {
            return response('No data found', 400);
        }

        foreach ($data[0] as $key => $value) {
            $header[] = $key;
        }

        $userImport->createUsers($header, $data);

        return response('Total users imported: ' . $count, 201);
    }

    public function editWrongUsersLive($id)
    {
        $data = TempTable::where('uuid', $id)->first();

        if (!$data) {
            return response('Cannot find the data', 400);
        }

        if ($data->user_id != Auth::user()->id) {
            return response('Access denied', 403);
        }

        $data = unserialize($data->data);

        return response($data, 200);
    }
}