<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UserApiController extends Controller
{
    public function postSidebarToggle(Request $request)
    {
        $userId = $request->user()->id;
        $user = User::where('id', $userId)->with('profile')->first();
        $options = $user->profile->options;

        if (isset($options['sidebar'])) {
            $options['sidebar'] = !$options['sidebar'];
        }

        $user->profile->options = $options;
        $user->profile->save();
        return response(['data' => $user], 200);
    }
}