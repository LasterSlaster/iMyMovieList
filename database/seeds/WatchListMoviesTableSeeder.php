<?php

use Illuminate\Database\Seeder;
use App\WatchListMovie;

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

        $watchListId->each(function($u)  {
           $watchListMovie = new WatchListMovie();
           $watchListMovie->watch_list_id = $u;
           $watchListMovie->movie_id = Movie::where('movie_code', 284053)->firstOrFail();
           $watchListMovie->save();
        });

    }
}
