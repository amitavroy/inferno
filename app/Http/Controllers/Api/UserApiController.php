<?php

namespace App\Http\Controllers\Api;

use App\Events\User\Activate;
use App\Events\User\Deleted;
use App\Http\Controllers\Controller;
use App\Repositories\Dashboard\DashboardRepository;
use App\Tokens;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use LRedis;

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

        $redis = \LRedis::connection();
        $redis->publish('message', $user);

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

        $redis = \LRedis::connection();
        $redis->publish('usr_image_uploaded', $imageUrl);

        return response(['data' => $imageUrl], 201);
    }

    /**
     * Activate a user from the admin interface.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function postActivateUser(Request $request)
    {
        try {
            DB::beginTransaction();

            // activate the user
            $user = User::find($request->input('userId'));
            $user->active = 1;
            $user->save();

            // remove the token
            $token = Tokens::where('user_id', $user->id)
                ->where('type', 'user_activation')
                ->first();
            $token->delete();

            event(new Activate($user));
            DB::commit();
            return response(['data' => $user], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            $message = $e->getMessage();
            return response(['error-message' => $message], 500);
        }
    }

    public function postDeleteUser(Request $request)
    {
        try {
            DB::beginTransaction();

            // remove the user
            $user = User::find($request->input('userId'));

            // remove the token
            $token = Tokens::where('user_id', $user->id)
                ->first();

            if ($token)
                $token->delete();

            event(new Deleted($user));
            $user->delete();

            DB::commit();
            return response(['data' => $user], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            $message = $e->getMessage();
        }
    }

    public function getUserWatchdogEntries(Request $request, DashboardRepository $dashboardRepository)
    {
        $userId = $request->user()->id;
        $userActivity = $dashboardRepository->userLastWeekActivities($userId);
        $labels = [];
        $rows = [];
        foreach ($userActivity as $value) {
            $labels[] = $value->date;
            $rows[] = $value->count;
        }

        $data = [
            'labels' => $labels,
            'rows' => $rows,
        ];
        return response()->json(['data' => $data], 200);
    }
}