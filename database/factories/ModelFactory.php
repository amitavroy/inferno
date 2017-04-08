<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Watchdog::class, function (Faker\Generator $faker) {
    $date = $faker->dateTimeBetween('-10 days', 'now');

    return [
        'description' => $faker->sentence(6, true),
        'level' => $faker->randomElement(['info', 'danger', 'warning']),
        'ip_address' => $faker->ipv4,
        'user_id' => $faker->randomElement([1,2]),
        'created_at' => $date,
        'updated_at' => $date,
    ];
});

