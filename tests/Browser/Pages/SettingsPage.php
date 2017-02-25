<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page as BasePage;

class SettingsPage extends BasePage
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/config/system/settings';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param Browser $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertPathIs($this->url());
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@save-setting' => '#setting-manage .btn-success',
            '@app-name-field' => '#setting-manage input[name=setting[app_name]]',
            '@add-setting-key' => '#add-setting-form input[name=name]',
            '@add-setting-value' => '#add-setting-form input[name=value]',
            '@add-setting-submit' => '#add-setting-form .btn-success'
        ];
    }
}
