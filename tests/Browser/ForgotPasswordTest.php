<?php

namespace Tests\Browser;

use App\User;
use Illuminate\Support\Facades\DB;
use Tests\Browser\Pages\ForgotPassword;
use Tests\DuskTestCase;

class ForgotPasswordTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->browse(function ($browser) {
            $browser->visit(new ForgotPassword())
                ->assertSee('Get email to reset your password.');
        });
    }

    public function testEmailFieldIsRequired()
    {
        $this->browse(function ($browser) {
            $browser->visit(new ForgotPassword())
                ->type('@email', '')
                ->click('@submitBtn')
                ->assertSee('The email field is required');
        });
    }

    public function testNonExistingEmailValidation()
    {
        $this->browse(function ($browser) {
            $emailAddress = time() . '@microsoft.com';

            $browser->visit(new ForgotPassword())
                ->type('@email', $emailAddress)
                ->click('@submitBtn')
                ->assertSee('This email address is not in our records.');
        });
    }

    public function testEmailGoesToCorrectEmailAddress()
    {
        $this->browse(function ($browser) {
            $emailAddress = 'reachme@amitavroy.com';

            $browser->visit(new ForgotPassword())
                ->type('@email', $emailAddress)
                ->click('@submitBtn')
                ->assertSee('Check your email for the link to change password.');
        });
    }

    public function testForgotResetPasswordPage()
    {
        $this->browse(function ($browser) {
            $emailAddress = 'reachme@amitavroy.com';

            $browser->visit(new ForgotPassword())
                ->type('@email', $emailAddress)
                ->click('@submitBtn')
                ->assertSee('Check your email for the link to change password.');

            $user = User::where('email', $emailAddress)->first();
            $data = DB::table('tokens')
                ->where('user_id', $user->id)
                ->where('type', 'forgot_password')
                ->first();

            $browser->visit('forgot-password/set/' . $data->token)
                ->type('password', '')
                ->type('confirm_password', '')
                ->click('.btn-primary')
                ->assertSee('The password field is required.')
                ->assertSee('The confirm password field is required.')
                ->type('password', 'somepassword')
                ->type('confirm_password', '')
                ->click('.btn-primary')
                ->assertSee('The confirm password field is required.')
                ->type('password', 'somepassword')
                ->type('confirm_password', 'somepassword1')
                ->click('.btn-primary')
                ->assertSee('The confirm password and password must match.')
                ->type('password', 'somepassword')
                ->type('confirm_password', 'somepassword')
                ->click('.btn-primary')
                ->pause(3000)
                ->assertPathIs('/')
                ->assertSee('You password has changed. Try logging in now.');

            $user->password = bcrypt('password');
            $user->save();
        });
    }

    public function testWrongTokenError()
    {
        $this->browse(function ($browser) {
            $browser->visit('forgot-password/set/123456')
                ->assertSee('Access Denied')
                ->assertSee('You are now allowed on this url.');
        });
    }
}
