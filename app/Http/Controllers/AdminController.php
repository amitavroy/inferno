<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Setting;

class AdminController extends Controller
{

    public function getConfigPage()
    {
        return view('adminlte.pages.admin.config');
    }

    public function getUserActivationPending()
    {
        $users = User::with('activation_token')
            ->where('active', 0)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('adminlte.pages.admin.user-activation-pending', compact('users'));
    }

    public function getSettingsPage()
    {
        $settings = Setting::all();
        return view('adminlte.pages.settings')->with('settings', $settings);
    }
}
