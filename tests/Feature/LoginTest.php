<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function a_user_can_login_with_correct_username()
    {
        $user = User::create([
            'name' => 'Faker',
            'email' => 'fake@gmail.com',
            'password' => bcrypt('password'),
            'status' => 1,
        ]);

        $response = $this->json('POST', '/login', ['email' => $user->email, 'password' => 'password'])
            ->assertRedirect('/dashboard');

        dump($response);
    }
}
