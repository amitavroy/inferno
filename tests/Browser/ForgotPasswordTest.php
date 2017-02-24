<?php

namespace Tests\Browser;

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
}
