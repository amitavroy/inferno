<?php

namespace Tests\Browser;

use Illuminate\Support\Facades\DB;
use Tests\Browser\Pages\ManageRolesPages;
use Tests\DuskTestCase;

class ManageRoleTest extends DuskTestCase
{
    protected $roleName;

    /**
     * ManageRoleTest constructor.
     * @internal param $roleName
     */
    public function __construct()
    {
        $this->roleName = 'Test Role';
    }

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->browse(function ($browser) {
            $browser->loginAs(1)
                ->visit(new ManageRolesPages())
                ->assertSee('Admin')
                ->assertSee('Auth User')
                ->assertSee('Manage Roles');
        });
    }

    /** @test */
    public function non_admin_user_cannot_see_manage_role_age()
    {
        $this->browse(function ($browser) {
            $browser->loginAs(2)
                ->visit(new ManageRolesPages())
                ->assertSee('Access Denied');
        });
    }

    /** @test */
    public function check_create_role_validation_message()
    {
        $this->browse(function ($browser) {
            $browser->loginAs(1)
                ->visit(new ManageRolesPages())
                ->type('@role-input', '')
                ->click('@role-submit')
                ->assertSee('The name field is required.');
        });
    }

    /** @test */
    public function check_new_role_is_getting_created()
    {
        $this->browse(function ($browser) {
            $browser->loginAs(1)
                ->visit(new ManageRolesPages())
                ->type('@role-input', $this->roleName)
                ->click('@role-submit')
                ->assertSee('Added a new Role')
                ->assertSee($this->roleName);
        });
    }

    /** @test */
    public function check_if_role_is_getting_edited()
    {
        $this->browse(function ($browser) {
            $role = DB::table('roles')->orderBy('id', 'desc')->first();
            $browser->loginAs(1)
                ->visit(route('edit-role', $role->id))
                ->assertSee($this->roleName)
                ->type('name', $this->roleName . 'edited')
                ->click('.btn-success')
                ->assertSee($this->roleName . 'edited');
        });
    }

    /** @test */
    public function check_admin_role_should_not_be_edited()
    {
        $this->browse(function ($browser) {
            $browser->loginAs(1)
                ->visit(route('edit-role', 1))
                ->type('name', $this->roleName . 'edited')
                ->click('.btn-success')
                ->assertSee('Access Denied');
        });
    }

    public function testRoleIsGettingDeleted()
    {
        $this->browse(function ($browser) {
            $browser->loginAs(1)
                ->visit(new ManageRolesPages())
                ->assertSee($this->roleName . 'edited')
                ->click('table tbody tr:last-child td .ConfirmModalWrapper button')
                ->click('table tbody tr:last-child td .ConfirmModalWrapper .modal .btn-success')
                ->visit(new ManageRolesPages())
                ->assertDontSee($this->roleName . 'edited');
        });
    }
}
