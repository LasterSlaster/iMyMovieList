<?php

use Illuminate\Database\Seeder;

class UserMovieRatingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\UserMovieRating::class, 50)->create();
    }
}
