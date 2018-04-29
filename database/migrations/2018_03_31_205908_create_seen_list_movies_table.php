<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeenListMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seen_list_movies', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('seen_list_id');
            $table->foreign('seen_list_id')
                ->references('id')->on('seen_lists')
                ->onDelete('cascade');
            $table->unsignedInteger('movie_id');
            $table->foreign('movie_id')
                ->references('id')->on('movies')
                ->onDelete('cascade');
            $table->unique(['seen_list_id', 'movie_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seen_list_movies');
    }
}
