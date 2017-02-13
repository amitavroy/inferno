<?php

namespace App\Presenters;

use App\Profile;
use Illuminate\Support\Facades\Auth;
use Laracasts\Presenter\Presenter;

class UserPresenter extends Presenter
{
    public function profilePic()
    {
        $profile = Profile::where('user_id', Auth::user()->id)->first();
        if ($profile->profile_pic != null && $profile->profile_pic != '') {
            return $profile->profile_pic;
        } else {
            return url('adminlte/avatar.png');
        }
    }
}