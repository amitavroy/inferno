<?php
/**
 * Created by PhpStorm.
 * User: amitavroy
 * Date: 03/03/17
 * Time: 9:53 AM
 */

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminApiController extends Controller
{
    public function postDeleteUser(Request $request)
    {
        $roleId = $request->input('id');

        if ($roleId == 1 || $roleId == 2) {
            abort(403, 'You cannot edit this role.');
        }

        DB::table('roles')->where('id', $roleId)->delete();
        
        return response(['data' => 'Role was deleted'], 200);
    }
}