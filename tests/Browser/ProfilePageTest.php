<?php

namespace Tests\Browser;

use Tests\DuskTestCase;

class ProfilePageTest extends DuskTestCase
{
    private $pageUrl;

    function __construct()
    {
        $this->pageUrl = '/user/profile';
    }

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->browse(function ($browser) {
            $exampleTest = new ExampleTest();
            $exampleTest->testBasicLogin();

            $browser->visit(new Pages\ProfilePage())
                ->assertSeeIn('section.content-header', 'My profile');
        });
    }

    /**
     * Test basic form for Display name is working with a name.
     *
     * @throws \Exception
     * @throws \Throwable
     */
    public function testUpdateName()
    {
        $this->browse(function ($browser) {
            $name = 'Amitav Roy';
            $browser->visit(new Pages\ProfilePage())
                ->type('name', $name)
                ->click('.btn-success')
                ->assertPathIs($this->pageUrl)
                ->assertSee('Profile saved')
                ->assertInputValue('name', $name);
        });
    }

    /**
     * Checking that the blank display field will return a valid error message.
     *
     * @throws \Exception
     * @throws \Throwable
     */
    public function testBlankNameNotAllowed()
    {
        $this->browse(function ($browser) {
            $browser->visit(new Pages\ProfilePage())
                ->type('name', '')
                ->click('.btn-success')
                ->assertPathIs($this->pageUrl)
                ->assertSee('You need to mention your name.');
        });
    }

    public function testProfileDataGetsSaved()
    {
        $this->browse(function ($browser) {
            $time = time();
            $country = 'India';
            $twitter = 'amitavroy7';
            $facebook = 'https://facebook.com';
            $skype = 'amitavroy';
            $linkedIn = 'amitavroy';
            $designation = 'Software developer';

            $browser->visit(new Pages\ProfilePage())
                ->type('country', $country . $time)
                ->type('twitter', $twitter . $time)
                ->type('facebook', $facebook . $time)
                ->type('skype', $skype . $time)
                ->type('linkedin', $linkedIn . $time)
                ->type('designation', $designation . $time)
                ->click('#profiled-edit-form .btn-success')
                ->assertPathIs($this->pageUrl)

                ->assertInputValue('country', $country . $time)
                ->assertInputValue('twitter', $twitter . $time)
                ->assertInputValue('facebook', $facebook . $time)
                ->assertInputValue('skype', $skype . $time)
                ->assertInputValue('linkedin', $linkedIn . $time)
                ->assertInputValue('designation', $designation . $time)

                ->type('country', $country)
                ->type('twitter', $twitter)
                ->type('facebook', $facebook)
                ->type('skype', $skype)
                ->type('linkedin', $linkedIn)
                ->type('designation', $designation)
                ->click('#profiled-edit-form .btn-success');
        });
    }
    
    public function testProfileImageUpload()
    {
//        $this->browse(function ($browser) {
//            $imagePath = public_path('adminlte/avtar.png');
//            $browser->visit(new Pages\ProfilePage())
//                ->click('#profile-pic-block .btn.btn-primary.btn-sm')
//                ->assertSee('Upload an Image')
//                ->attach('image-upload', $imagePath)
//                ->click('#uploadFileCall')
//                ->waitUntilMissing('.Image-upload .Modal')
//                ->visit($this->pageUrl);
//        });
    }
}
