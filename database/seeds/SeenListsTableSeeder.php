<?php

use Illuminate\Database\Seeder;

class SeenListsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\SeenList::class, 50)->create();
    }
}
