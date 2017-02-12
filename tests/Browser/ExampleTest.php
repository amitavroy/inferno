<?php

namespace Tests\Browser;

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
                    ->assertSee('Inferno');
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
}
