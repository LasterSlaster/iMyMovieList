<?php

use Illuminate\Database\Seeder;

class WatchListsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\WatchList::class, 50)->create();
    }
}
