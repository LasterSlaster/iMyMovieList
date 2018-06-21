<?php

use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

$factory->define(\App\SeenListMovie::class, function (Faker $faker) {
    $seenListId = DB::table('seen_lists')->pluck('id')->toArray();
    $movieId = DB::table('movies')->pluck('id')->toArray();
    return [
        'seen_list_id' => $faker->randomElement($seenListId),
        'movie_id' => $faker->randomElement($movieId),
    ];
});
