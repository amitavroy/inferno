<?php

namespace Tests\Browser;

use Setting;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ExampleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Hell awaits you')
                    ->assertSee(Setting::get('app_name'));
        });
    }

    /**
     * Check if the user is able to login to the application
     * with default username and password added from seed
     *
     * @throws \Exception
     * @throws \Throwable
     */
    public function testBasicLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->type('email', 'reachme@amitavroy.com')
                ->type('password', 'password')
                ->click('.btn-primary')
                ->assertSee('Dashboard');
        });
    }

    /**
     * Check whether the User can logout properly
     * and then sees the Login screen.
     *
     * @throws \Exception
     * @throws \Throwable
     */
    public function testUserLogout()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/dashboard')
                ->assertSee('Dashboard')
                ->click('.main-header #user-dropdown-menu')
                ->click('#logout-button')
                ->assertSee('Inferno')
                ->assertSee('You have been logged out')
                ->visit('/dashboard')
                ->assertDontSee('Dashboard');
        });
    }

    /**
     * Validate that if credentials are wrong, we are getting wrong error message.
     *
     * @throws \Exception
     * @throws \Throwable
     */
    public function testWrongLoginMessage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->type('email', 'reachme@amitavroy.com')
                ->type('password', 'password123')
                ->click('.btn-primary')
                ->assertSee('Check your username and password again')
                ->assertPathIs('/');
        });
    }

    public function testSocialLoginButtonOnStates()
    {
        $this->browse(function (Browser $browser) {
            $settingOriginal = Setting::get('social_login');
            Setting::set('social_login', true);
            Setting::save();

            $browser->visit('/')
                ->assertSeeIn('.btn-facebook', 'Sign in using Facebook')
                ->assertSeeIn('.btn-google', 'Sign in using Google+');

            Setting::set('social_login', false);
            Setting::save();

            $browser->visit('/')
                ->assertDontSee('Sign in using Facebook')
                ->assertDontSee(' Sign in using Google+');

            Setting::set('social_login', $settingOriginal);
            Setting::save();
        });
    }

    public function testRegisterLinkStates()
    {
        $this->browse(function (Browser $browser) {
            $settingOriginal = Setting::get('user_can_register');
            Setting::set('user_can_register', false);
            Setting::save();

            $browser->visit('/')
                ->assertDontSee('Register a new membership')
                ->visit('/register')
                ->assertSee('Page not found.');

            Setting::set('user_can_register', true);
            Setting::save();
            $browser->visit('/')
                ->assertSee('Register a new membership')
                ->visit('/register')
                ->assertSee('Hell awaits you... register with us');

            Setting::set('user_can_register', $settingOriginal);
            Setting::save();
        });
    }
}
