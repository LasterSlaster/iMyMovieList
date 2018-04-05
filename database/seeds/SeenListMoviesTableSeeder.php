<?php

use Illuminate\Database\Seeder;

class SeenListMoviesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1, 50) as $index) {
            DB::table('seen_list_movies')->insert([
                'seen_list_id' => factory(App\SeenList::class)->create()->id,
                'movie_id' => factory(App\Movie::class)->create()->id,
            ]);
        }
    }
}
