<?php

namespace App\Http\Controllers;

use App\Events\User\LoggedIn;
use App\Events\User\LoggedOut;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'active' => 1
        ];

        $remember = false;
        if ($request->input('remember')) {
            $remember = true;
        }

        if (Auth::attempt($credentials, $remember)) {
            event(new LoggedIn());
            return redirect()->intended('dashboard');
        }

        flash('Cannot login. Check your username and password again', 'danger');
        return redirect()->back();
    }
    
    public function postLogout(Request $request)
    {
        event(new LoggedOut());
        Auth::logout();
        flash('You have been logged out');
        return redirect('/');
    }

    public function pageDashboard()
    {
        return view('adminlte.pages.dashboard');
    }
}
