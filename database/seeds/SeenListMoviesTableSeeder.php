<?php

use Illuminate\Database\Seeder;
use App\SeenListMovie;
use App\Movie;

class SeenListMoviesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seenListId = DB::table('seen_lists')->pluck('id');
        $movie = Movie::where('movie_code', 383498)->firstOrFail();

        $seenListId->each(function($u) use ($movie) {
            $seenListMovie = new SeenListMovie();
            $seenListMovie->seen_list_id = $u;
            $seenListMovie->movie_id = $movie->id;
            $seenListMovie->save();
        });
    }
}
