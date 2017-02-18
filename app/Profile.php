<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = ['user_id', 'profile_pic', 'country', 'twitter', 'facebook', 'skype', 'linkedin', 'options'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getOptionsAttribute($value)
    {
        return unserialize($value);
    }
    public function setOptionsAttribute($value)
    {
        $this->attributes['options'] = serialize($value);
    }

    public function removeCurrentProfilePic($userWithProfile)
    {
        if ($userWithProfile->profile->profile_pic != '') {
            $url = $userWithProfile->profile->profile_pic;
            $fileName = explode('/', $url);
            $fileName = $fileName[count($fileName) - 1];
            unlink(public_path('profile_pics/') . $fileName);
        }
    }
}
