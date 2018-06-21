<?php

use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

$factory->define(\App\WatchListMovie::class, function (Faker $faker) {
    $watchListId = DB::table('watch_lists')->pluck('id')->toArray();
    $movieId = DB::table('movies')->pluck('id')->toArray();
    return [
        'watch_list_id' => $faker->randomElement($watchListId),
        'movie_id' => $faker->randomElement($movieId),
    ];
});
