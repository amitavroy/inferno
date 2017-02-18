<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tokens extends Model
{
    public $timestamps = false;

    protected $fillable = ['user_id', 'token', 'created_at', 'expiry_at', 'type'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
