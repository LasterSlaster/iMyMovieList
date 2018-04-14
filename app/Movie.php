<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    public function comments() {
        return $this->hasMany('App\Comment');
    }

    public function userMovieRatings() {
        return $this->hasMany('App\UserMovieRating');
    }

    public function watchLists() {
        return $this->belongsToMany('App\WatchList', 'watch_list_movies', 'movie_id', 'watch_list_id');
    }

    public function seenLists() {
        return $this->belongsToMany('App\SeenList', 'seen_list_movies', 'movie_id', 'watch_list_id');
    }
}
