<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UserApiController extends Controller
{
    /**
     * Handling saving of the user sidebar preference into the profile table.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
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

    /**
     * Handling the Ajax request to upload the profile pic of the user.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function postUploadProfilePic(Request $request)
    {
        $data = $request->input('img');
        list($type, $data) = explode(';', $data);
        list(, $data)      = explode(',', $data);

        $data = base64_decode($data);
        $imageName = time().'.png';
        $path = public_path('profile_pics/');
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        file_put_contents($path . $imageName, $data);

        $imageUrl = url('profile_pics/' . $imageName);
        $user = User::with('profile')->find($request->user()->id);
        $user->profile->removeCurrentProfilePic($user);
        $user->profile->profile_pic = $imageUrl;
        $user->profile->save();

        return response(['data' => $imageUrl], 201);
    }
}