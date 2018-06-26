<?php

use Illuminate\Database\Seeder;
use App\UserMovieRating;
use Faker\Generator as Faker;
use App\SeenListMovie;

class UserMovieRatingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seenlistMovies = SeenListMovie::all();

        $seenlistMovies->each(function($u) {
            $seenlist = $u->seenlist();
            $rating = new UserMovieRating();
            $rating->user_id = $seenlist->user_id;
            $rating->movie_id = $u->movie_id;
            $rating->rating = 2;
            $rating->save();
        });
    }
}
