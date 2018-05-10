<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Movie represents a model of the movie table
 * @package App
 */
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

    /**
     * Provides access to the related comments of this movie
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments() {
        return $this->hasMany('App\Comment');
    }

    /**
     * Provides access to the related userMovieRatings of this movie
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userMovieRatings() {
        return $this->hasMany('App\UserMovieRating');
    }

    /**
     * Provides access to the related watchLists of this movie
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function watchLists() {
        return $this->belongsToMany('App\WatchList', 'watch_list_movies', 'movie_id', 'watch_list_id');
    }

    /**
     * Provides access to the related seenLists of this movie
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function seenLists() {
        return $this->belongsToMany('App\SeenList', 'seen_list_movies', 'movie_id', 'watch_list_id');
    }
}
