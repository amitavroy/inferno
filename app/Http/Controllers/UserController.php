<?php

namespace App\Http\Controllers;

use App\Events\User\LoggedIn;
use App\Events\User\LoggedOut;
use App\Events\User\ProfileEdited;
use App\Events\User\Registered;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UserRegisterRequest;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function getRegistrationPage()
    {
        return view('adminlte.pages.register');
    }

    public function postHandleUserRegistration(UserRegisterRequest $request)
    {
        $user = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'active' => 0
        ];

        try {
            DB::beginTransaction();
            $registeredUser = User::create($user);
            event(new Registered($registeredUser));
            DB::commit();
            flash('Registration done. Check email to activate account.', 'success');
            return redirect()->back();
        } catch (Exception $e) {
            DB::rollBack();
            $message = '';
            if (env('APP_ENV') == 'local') {
                $message = $e->getMessage();
            }
            abort(500, 'Data was not saved. ' . $message);
        }
    }

    /**
     * Handling the login page's post request.
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'active' => 1 // user should be active to be able to login
        ];

        // handling the checkbox for remember
        $remember = false;
        if ($request->input('remember')) {
            $remember = true;
        }

        // doing the attempt for login
        if (Auth::attempt($credentials, $remember)) {
            event(new LoggedIn());
            return redirect()->intended('dashboard');
        }

        flash('Cannot login. Check your username and password again', 'danger');
        return redirect()->back();
    }

    /**
     * Logout handling is now a post request.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postLogout(Request $request)
    {
        event(new LoggedOut());
        Auth::logout();
        flash('You have been logged out');
        return redirect('/');
    }

    /**
     * This method will give user his personalized dashboard.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function pageDashboard()
    {
        return view('adminlte.pages.dashboard');
    }

    public function pageUserProfile()
    {
        return view('adminlte.pages.user-profile');
    }

    /**
     * Handling the User's profile update.
     *
     * @param UpdateProfileRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postUpdateProfile(UpdateProfileRequest $request)
    {
        $user = User::with('profile')->find($request->user()->id);
        $user->name = $request->input('name');
        $user->save();

        // saving all profile fields also. Not checking if there is a change
        $user->profile->country = $request->input('country');
        $user->profile->twitter = $request->input('twitter');
        $user->profile->facebook = $request->input('facebook');
        $user->profile->skype = $request->input('skype');
        $user->profile->linkedin = $request->input('linkedin');
        $user->profile->designation = $request->input('designation');
        $user->profile->save();

        event(new ProfileEdited());
        flash('Profile saved', 'info');
        return redirect()->back();
    }

    public function getSettingsPage()
    {
        return view('adminlte.pages.settings');
    }
}
