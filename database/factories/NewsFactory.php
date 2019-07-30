<?php

use Faker\Generator as Faker;

$factory->define(App\News::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'user_id' => rand(1,20),
        'body' => $faker->realText(),
        'slug' => 'the_slug_'.rand(1,100),
    ];
});
