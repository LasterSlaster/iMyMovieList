<?php

use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

$factory->define(App\Comment::class, function (Faker $faker) {
    $usersIDs = DB::table('users')->pluck('id')->toArray();
    $moviesIDs = DB::table('movies')->pluck('id')->toArray();
    return [
        'user_id' => $faker->randomElement($usersIDs),
        'movie_id' => $faker->randomElement($moviesIDs),
        'comment_text' => $faker->paragraph(4)
    ];
});
