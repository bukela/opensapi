<?php

use Faker\Generator as Faker;

$factory->define(App\Project::class, function (Faker $faker) {

    $donators = App\User::all()->where('role_id', 2)->pluck('id')->toArray();
    
    return [
        'title' => $faker->word,
        'organization_id' => rand(1, 20),
        'approved_funds' => rand(100, 200000),
        'donator_id' => $donators[array_rand($donators)],
        'description' => $faker->realText()
    ];
});
