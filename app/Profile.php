<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = ['profile_pic', 'country', 'twitter', 'facebook', 'skype', 'linkedin', 'options'];

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
}
