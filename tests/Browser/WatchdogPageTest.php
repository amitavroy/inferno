<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class WatchdogPageTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->browse(function ($browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/config/activities')
                    ->assertSee('My activities');
        });
    }

    public function testSearchTextRemains()
    {
        $this->browse(function ($browser) {
            $browser->visit('/config/activities')
                ->type('search_text', 'Hello world')
                ->click('.btn-success')
                ->assertPathIs('/config/activities')
                ->assertSee('My activities')
                ->assertInputValue('search_text', 'Hello world');
        });
    }
}
