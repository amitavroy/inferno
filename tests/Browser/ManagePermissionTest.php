<?php

namespace Tests\Browser;

use App\User;
use Illuminate\Support\Facades\DB;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ManagePermissionTest extends DuskTestCase
{
    /** @test */
    public function normal_user_should_not_see_manage_permissions_page()
    {
        $this->browse(function ($browser) {
            $browser->loginAs(User::find(2))
                ->visit('/config/user/permissions')
                ->assertSee('Access Denied');
        });
    }

    /** @test */
    public function admin_user_should_see_manage_permissions()
    {
        $this->browse(function ($browser) {
            $browser->loginAs(User::find(1))
                ->visit('/config/user/permissions')
                ->assertSee('Manage permissions');
        });
    }

    /** @test */
    public function admin_can_create_a_new_permission()
    {
        $this->browse(function ($browser) {
            $browser->loginAs(User::find(1))
                ->visit('/config/user/permissions')
                ->type('name', 'test-permission')
                ->click('#perm-save-form .btn-success')
                ->assertSee('Test-permission');
        });
    }

    /** @test */
    public function blank_role_name_should_not_get_created()
    {
        $this->browse(function ($browser) {
            $browser->loginAs(User::find(1))
                ->visit('/config/user/permissions')
                ->type('name', '')
                ->click('#perm-save-form .btn-success')
                ->assertSee('The name field is required.');
        });
    }

    /** @test */
    public function admin_can_edit_role()
    {
        $this->browse(function ($browser) {
            $perm = DB::table('permissions')->orderBy('id', 'desc')->first();

            $browser->loginAs(User::find(1))
                ->visit('/config/user/permissions')
                ->click('table tbody tr:last-child td .btn-primary')
                ->assertPathIs('/config/user/permission/' . $perm->id)

                ->type('name', '')
                ->click('.btn-success')
                ->assertPathIs('/config/user/permission/' . $perm->id)
                ->assertSee('The name field is required.')

                ->type('name', 'Test-permission-test')
                ->click('.btn-success')
                ->assertPathIs('/config/user/permission/' . $perm->id)
                ->assertSee('Permission was updated');
        });
    }

    /** @test */
    public function admin_can_delete_a_role()
    {
        $this->browse(function ($browser) {
            $browser->loginAs(User::find(1))
                ->visit('/config/user/permissions')
                ->click('table tbody tr:last-child td .ConfirmModalWrapper button')
                ->click('table tbody tr:last-child td .ConfirmModalWrapper .modal .btn-success')
                ->visit('/config/user/permissions')
                ->assertDontSee('Test-permission');
        });
    }
}
