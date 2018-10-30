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
    
    $gender = $faker->randomElements(['Male', 'Female']);

    return [
        'name' => $faker->name,
        'username' => $faker->username,
        'email' => $faker->unique()->safeEmail,
        'approved' => 1,
        'gender' => "",
        'sector_id' => rand(1,3),
        'team_id' => rand(1,12),
        'department_id' => rand(1,4),
        'country_id' => rand(1,3),
        'city_id' => rand(1,3),
        'prefered_language' => rand(1,4),
        'city_id' => rand(1,3),
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});
