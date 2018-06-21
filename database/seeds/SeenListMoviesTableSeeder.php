<?php

use Illuminate\Database\Seeder;
use App\SeenListMovie;

class SeenListMoviesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seenListId = DB::table('seen_lists')->pluck('id')->toArray();

        $seenListId->each(function($u)  {
            $faker = new Faker();
            $movieId = DB::table('movies')->pluck('id')->toArray();
            $seenListMovie = new SeenListMovie();
            $seenListMovie->seen_list_id = $u->id;
            $seenListMovie->movie_id = $faker->randomElement($movieId);
            $seenListMovie->save();
        });
    }
}
