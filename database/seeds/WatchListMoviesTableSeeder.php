<?php

use Illuminate\Database\Seeder;
use App\WatchListMovie;
use App\Movie;

class WatchListMoviesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $watchListId = DB::table('watch_lists')->pluck('id');
        $movie = Movie::where('movie_code', 284053)->firstOrFail();
        $watchListId->each(function($u) use ($movie) {
           $watchListMovie = new WatchListMovie();
           $watchListMovie->watch_list_id = $u;
           $watchListMovie->movie_id = $movie->id;
           $watchListMovie->save();
        });

    }
}
