<?php

namespace Tests\Browser;

use App\User;
use Setting;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RegistrationTest extends DuskTestCase
{
    protected $time;

    function __construct()
    {
        $this->time = time();
    }

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        if (Setting::get('user_can_register')) {
            $this->browse(function ($browser) {
                $browser->visit(new Pages\RegistrationPage())
                    ->assertSee('Hell awaits you... register with us')
                    ->assertSeeIn('.btn-primary', 'Register');
            });
        }
    }

    public function testValidationMessages()
    {
        if (Setting::get('user_can_register')) {
            $this->browse(function ($browser) {
                $browser->visit(new Pages\RegistrationPage())
                    ->type('name', '')
                    ->type('email', '')
                    ->type('password', '')
                    ->type('cpassword', '')
                    ->click('.btn-primary')
                    ->assertSee('The name field is required.')
                    ->assertSee('The email field is required.')
                    ->assertSee('The password field is required.')
                    ->assertSee('You need to confirm your password.');
            });
        }
    }

    /**
     * @throws \Exception
     * @throws \Throwable
     */
    public function testPasswordNotMatchingError()
    {
        if (Setting::get('user_can_register')) {
            $this->browse(function ($browser) {
                $browser->visit(new Pages\RegistrationPage())
                    ->type('name', 'Jhon Doe' . $this->time)
                    ->type('email', 'jhondoe' . $this->time . '@gmail.com')
                    ->type('password', 'password')
                    ->type('cpassword', 'password123')
                    ->click('.btn-primary')
                    ->assertSee('This should match your password field.');
            });
        }
    }

    public function testActualRegistration()
    {
        if (Setting::get('user_can_register')) {
            $this->browse(function ($browser) {
                $browser->visit(new Pages\RegistrationPage())
                    ->type('name', 'Jhon Doe' . $this->time)
                    ->type('email', 'jhondoe' . $this->time . '@gmail.com')
                    ->type('password', 'password')
                    ->type('cpassword', 'password')
                    ->click('.btn-primary')
                    ->assertSee('Registration done. Check email to activate account.');
            });
        }
    }

    public function testWatchdogEntryOfNewUser()
    {
        if (Setting::get('user_can_register')) {
            $this->browse(function ($browser) {
                $exampleTest = new ExampleTest();
                $exampleTest->testBasicLogin();
                $string = 'A new User Jhon Doe' . $this->time . ' registered. Activation is pending.';

                $browser->visit('config/system/activities')
                    ->assertSee($string);
            });
        }
    }

    public function testActivationPending()
    {
        if (Setting::get('user_can_register')) {
            $this->browse(function ($browser) {
                $browser->visit('config/user/activation-pending')
                    ->assertSee('Users in the system whose\'s activation is pending')
                    ->assertSeeIn('.table tbody tr:nth-child(1)', 'Jhon Doe' . $this->time);
            });
        }
    }

    public function testInactiveUserCannotLogin()
    {
        if (Setting::get('user_can_register')) {
            $this->browse(function ($browser) {
                $browser->visit('/')
                    ->type('email', 'jhondoe' . $this->time . '@gmail.com')
                    ->type('password', 'password')
                    ->click('.btn-primary')
                    ->assertPathIs('/')
                    ->assertSee('Cannot login. Check your username and password again');
            });
        }
    }

    public function testClickActivationOfUser()
    {
        if (Setting::get('user_can_register')) {
            $this->browse(function ($browser) {
                $browser->loginAs(User::find(1))
                    ->visit('config/user/activation-pending')
                    ->click('.table tbody tr:nth-child(1) td:last-child div.activate-button .ConfirmModalWrapper .btn-success')
                    ->click('.table tbody tr:nth-child(1) td:last-child div.activate-button .ConfirmModalWrapper .modal-content .btn-success');

                $browser->visit('/')
                    ->type('email', 'jhondoe' . $this->time . '@gmail.com')
                    ->type('password', 'password')
                    ->click('.btn-primary')
                    ->assertPathIs('/dashboard')
                    ->assertSee('Dashboard');
            });
        }
    }
}
