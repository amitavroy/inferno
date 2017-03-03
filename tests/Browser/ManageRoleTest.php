<?php

namespace Tests\Browser;

use Tests\Browser\Pages\ManageRolesPages;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ManageRoleTest extends DuskTestCase
{
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

    public function testNonAdminUserCannotSeeManageRolesPage()
    {
        $this->browse(function ($browser) {
            $browser->loginAs(2)
                ->visit(new ManageRolesPages())
                ->assertSee('Access Denied');
        });
    }
}
