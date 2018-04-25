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
        factory(SeenListMovie::class, 50)->create();
    }
}
