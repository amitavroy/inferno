<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
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
    }
}
