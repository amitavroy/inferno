<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function getConfigPage()
    {
        return view('adminlte.pages.admin.config');
    }

    public function getUserActivationPending()
    {
        $users = User::with('activation_token')->where('active', 0)->get();
        return view('adminlte.pages.admin.user-activation-pending', compact('users'));
    }
}
