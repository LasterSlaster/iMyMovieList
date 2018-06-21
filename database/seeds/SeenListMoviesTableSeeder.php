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
        $seenListId = DB::table('seen_lists')->pluck('id');

        $seenListId->each(function($u)  {
            $faker = Faker\Factory::create();
            $movieId = DB::table('movies')->pluck('id')->toArray();
            $seenListMovie = new SeenListMovie();
            $seenListMovie->seen_list_id = $u;
            $seenListMovie->movie_id = $faker->randomElement($movieId);
            $seenListMovie->save();
        });
    }
}
