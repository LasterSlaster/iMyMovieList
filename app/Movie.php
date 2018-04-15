<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'movie_data' => 'array',
    ];

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
