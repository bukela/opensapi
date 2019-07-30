<?php

use Faker\Generator as Faker;

$factory->define(App\Organization::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'email' => $faker->unique()->safeEmail,
        'description' => $faker->realText(),
        'moderator' => $faker->rand(0,1),
        'active' => 1,

    ];
});
