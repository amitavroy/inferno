<?php

namespace Tests\Browser;

use App\User;
use Tests\Browser\Pages\SettingsPage;
use Tests\DuskTestCase;

class SettingsPageTest extends DuskTestCase
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
                ->visit(new SettingsPage())
                ->assertSee('Configuration');
        });
    }

    public function testAddSettingFormRequireValidation()
    {
        $this->browse(function ($browser) {
            $browser->visit(new SettingsPage())
                ->type('@add-setting-key', '')
                ->type('@add-setting-value', '')
                ->click('@add-setting-submit')
                ->assertSee('The value field is required.')
                ->assertSee('The name field is required.');
        });
    }
}
