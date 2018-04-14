<?php

use Faker\Generator as Faker;

$factory->define(App\Movie::class, function (Faker $faker) {
    return [
        'movie_code' => $faker->randomDigitNotNull
    ];
});
