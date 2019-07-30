<?php

use Faker\Generator as Faker;
use Illuminate\Support\Carbon;
/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Event::class, function (Faker $faker) {
            $year = rand(2009, 2016);
            $month = rand(1, 12);
            $day = rand(1, 28);

            $date = Carbon::create($year,$month ,$day , 0, 0, 0);
    return [
        'title' => $faker->word,
        'user_id' => rand(1,20),
        'start_date' => $date->format('Y-m-d'),
        'end_date' => $date->format('Y-m-d'),
        'content' => $faker->realText(),
        'slug' => 'the_slug_'.rand(1,100),
        
    ];
});
