<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWatchListMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('watch_list_movies', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('watch_list_id');
            $table->foreign('watch_list_id')
                ->references('id')->on('watch_lists')
                ->onDelete('cascade');
            $table->unsignedInteger('movie_id');
            $table->foreign('movie_id')
                ->references('id')->on('movies')
                ->onDelete('cascade');
            $table->unique(['watch_list_id', 'movie_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('watch_list_movies');
    }
}
