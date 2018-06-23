<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(UsersTableAdminSeeder::class);
        $this->call(UsersTableExampleSeeder::class);
        $this->call(MoviesTableSeeder::class);
        $this->call(CommentsTableSeeder::class);
        $this->call(UserMovieRatingsTableSeeder::class);
        $this->call(WatchListMoviesTableSeeder::class);
        $this->call(SeenListMoviesTableSeeder::class);
    }
}
