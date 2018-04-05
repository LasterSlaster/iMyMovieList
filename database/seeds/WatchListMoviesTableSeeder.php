<?php

use Illuminate\Database\Seeder;

class WatchListMoviesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ( range(1,50) as $item) {
            DB::table('watch_list_movies')->insert([
                'watch_list_id' => factory(App\WatchList::class)->create()->id,
                'movie_id' => factory(App\Movie::class)->create()->id,
            ]);
        }
    }
}
