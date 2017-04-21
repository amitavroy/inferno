<?php

namespace App\Http\Controllers;

use App\Events\User\LoggedIn;
use App\Events\User\LoggedOut;
use App\Events\User\ProfileEdited;
use App\Events\User\Registered;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetForgotPasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Mail\ForgotPasswordMail;
use App\Repositories\Watchdog\WatchdogRepository;
use App\Tokens;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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
        $dashboardData = [
            'activation_pending' => DB::table('users')->where('active', '=', 0)->count(),
            'my_recent_activities' => DB::table('watchdogs')->where('user_id', request()->user()->id)->count(),
        ];

        return view('adminlte.pages.dashboard', compact('dashboardData'));
    }

    /**
     * Get the User's profile page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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

    /**
     * This function will handle the request for a user to change password
     * from profile page.
     *
     * @param ChangePasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postHandlePasswordChange(ChangePasswordRequest $request)
    {
        $currentPassword = $request->input('current_password');
        $newPassword = $request->input('new_password');
        $confirmPassword = $request->input('confirm_password');

        $credentials = [
            'email' => Auth::user()->email,
            'password' => $currentPassword
        ];

        if (Auth::attempt($credentials)) {
            Auth::user()->password = bcrypt($confirmPassword);
            Auth::user()->save();

            flash('Your password is now changed.');
            return redirect()->back();
        }

        flash('Check if your current password is correct.', 'warning');
        return redirect()->back();
    }

    /**
     * Handling the Forgot password request.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postForgotPassword(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email'
        ]);

        $email = $request->input('email');
        $user = User::where('email', $email)->first();
        if (!$user) {
            flash('This email address is not in our records.', 'warning');
            return redirect()->back();
        }

        Tokens::where('user_id', $user->id)->delete();

        $token = Tokens::create([
            'user_id' => $user->id,
            'type' => 'forgot_password',
            'token' => uniqid(),
            'created_at' => Carbon::now(),
            'expiry_at' => Carbon::now(),
        ]);

        $token = Tokens::find($token->id);

        Mail::to($user)->send(new ForgotPasswordMail($token));
        flash('Check your email for the link to change password.');
        return redirect()->back();
    }

    public function getSetForgotPassword($token, Request $request)
    {
        $token = Tokens::where('token', $token)->first();

        if (!$token) {
            abort(403, 'You are now allowed on this url.');
        }

        return view('adminlte.pages.reset-forgot-password')->with('token', $token->token);
    }

    public function postSetForgotPassword(ResetForgotPasswordRequest $request)
    {
        $token = $request->input('token');
        $password = $request->input('password');

        $tokenData = DB::table('tokens')
            ->where('token', $token)
            ->where('type', 'forgot_password')
            ->where('expiry_at', '>', Carbon::now())
            ->first();

        if (!$tokenData) {
            flash('Wrong link. Check again.');
            return redirect('/');
        }

        $user = User::find($tokenData->user_id);
        $user->password = bcrypt($password);
        $user->save();

        flash('You password has changed. Try logging in now.');
        return redirect('/');
    }

    public function pageMyActivities(WatchdogRepository $watchdog, Request $request)
    {
        $rows = $watchdog->getUserActivityList(Auth::user()->id, []);
        $options = null;

        return view('adminlte.pages.watchdog', compact('rows', 'options'));
    }
}
