<?php

use Illuminate\Database\Seeder;
use App\WatchListMovie;
use Faker\Generator as Faker;

class WatchListMoviesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $watchListId = DB::table('watch_lists')->pluck('id')->toArray();

        $watchListId->each(function($u)  {
            $faker = new Faker();
            $movieId = DB::table('movies')->pluck('id')->toArray();
           $watchListMovie = new WatchListMovie();
           $watchListMovie->watchlist_id = $u->id;
           $watchListMovie->movie_id = $faker->randomElement($movieId);
           $watchListMovie->save();
        });

    }
}
