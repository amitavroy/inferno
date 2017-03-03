<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    private $admin;
    private $authUser;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createRoles();
        $this->createAdminUser();
        $this->createAuthUser();
    }

    public function createRoles()
    {
        $this->admin = Role::create([
            'name' => 'admin'
        ]);

        $this->authUser = Role::create([
            'name' => 'auth user'
        ]);
    }

    public function createAdminUser()
    {
        $user = App\User::create([
            'name' => 'Amitav Roy',
            'email' => 'reachme@amitavroy.com',
            'password' => bcrypt('password'),
            'active' => 1,
        ]);

        $profile = App\Profile::create([
            'user_id' => $user->id,
            'country' => 'India',
            'designation' => 'Web developer',
            'options' => ['sidebar' => true]
        ]);

        $user->assignRole(['admin', 'auth user']);
    }

    public function createAuthUser()
    {
        $user = App\User::create([
            'name' => 'Jhon Doe',
            'email' => 'jhon.doe@gmail.com',
            'password' => bcrypt('password'),
            'active' => 1,
        ]);

        $profile = App\Profile::create([
            'user_id' => $user->id,
            'country' => 'USA',
            'designation' => 'Sales Manager',
            'options' => ['sidebar' => true]
        ]);

        $user->assignRole(['auth user']);
    }
}
