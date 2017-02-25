<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingAddRequest;
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

    public function postHandleSettingsPageSave(Request $request)
    {
        $settings = $request->input('setting');

        foreach ($settings as $key => $value) {
            if ($value === "1") {
                $value = true;
            }
            if ($value === "0") {
                $value = false;
            }
            Setting::set($key, $value);
        }

        Setting::save();
        flash('Settings are now saved.');
        return redirect()->back();
    }

    public function postHandleSettingsPageAdd(SettingAddRequest $request)
    {
        $key = $request->input('name');
        $value = $request->input('value');

        if ($value === "1") {
            $value = true;
        }
        if ($value === "0") {
            $value = false;
        }

        Setting::set($key, $value);
        Setting::save();

        flash('The new setting is now added.');
        return redirect()->back();
    }
}
