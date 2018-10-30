<?php

use Faker\Generator as Faker;

$factory->define(App\Organization::class, function (Faker $faker) {
    return [
        'language_id' => rand(1, 4),
        'name' => $faker->company,
        'slug' => str_slug($faker->company),
        'acronym' => strtoupper($faker->name),
        'website' => $faker->url,
        'industry_id' => rand(1,3),
        'sector_id' => rand(1,12),
        'country_id' => rand(1,3)
    ];
});
