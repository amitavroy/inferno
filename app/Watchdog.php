<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Watchdog extends Model
{
    protected $fillable = ['description', 'level', 'user_id', 'ip_address'];
}
