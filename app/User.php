<?php

namespace App;

use App\Presenters\UserPresenter;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laracasts\Presenter\PresentableTrait;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, PresentableTrait, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'active',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $presenter = UserPresenter::class;

    public function profile()
    {
        return $this->hasOne('App\Profile');
    }

    public function tokens()
    {
        return $this->hasMany('App\Tokens');
    }
    
    public function activation_token()
    {
        return $this->hasOne('App\Tokens')
            ->where('type', '=', 'user_activation');
    }
}
