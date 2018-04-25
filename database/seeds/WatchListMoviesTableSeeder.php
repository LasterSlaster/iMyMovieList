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
        factory(WatchListMovie::class, 50)->create();
    }
}
