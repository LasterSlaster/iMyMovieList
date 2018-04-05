<?php

use Faker\Generator as Faker;

$factory->define(App\UserMovieRating::class, function (Faker $faker) {
    $usersIDs = DB::table('users')->pluck('id')->toArray();
    $moviesIDs = DB::table('movies')->pluck('id')->toArray();
    return [
        'user_id' => $faker->randomElement($usersIDs),
        'movie_id' => $faker->randomElement($moviesIDs),
        'rating' => $faker->numberBetween(1,5)
    ];
});
