<?php

use Faker\Generator as Faker;

$factory->define(App\Profile::class, function (Faker $faker) {
	$gender = $faker->randomElements(['Mr.', 'Ms.', 'Mrs.']);
    return [
        'language_id' => rand(1,4),
        'title' => "Mr.",
        'fullname' => $faker->name,
        'lastname' => $faker->lastname,
        'slug' => str_slug($faker->name),
        'bio' => $faker->text,
        'position' => $faker->firstname,
        'organization_id' => rand(1, 500),
        'photo' => "",
        'sector_id' => rand(1, 3),
        'date_networked' => $faker->date,
        'country_id' => rand(1, 3),
        'city_id' => rand(1, 3),
        'mobile_no' => $faker->phoneNumber,
        'mobile_no2' =>  $faker->phoneNumber,
        'mobile_no_other' =>  $faker->phoneNumber,
        'work_number' =>  $faker->phoneNumber,
        'work_number2' =>  $faker->phoneNumber,
        'work_number_other' =>  $faker->phoneNumber,
        'email' =>  $faker->email,
        'email2' => $faker->email,
        'assistant_name' => $faker->name,
        'assistant_number' => $faker->phoneNumber,
        'assistant_email' => $faker->email,
        'team_id' => rand(1,12),
        'fruit_level' => rand(1,4),
        'fruit_stage' => rand(1,3),
        'maintainer' => rand(1,3),
        'fruit_role' => rand(1,4),
        'history' => rand(1,3),
    ];
});
