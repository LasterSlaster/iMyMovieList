<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class WatchList representing a model of the watchList table
 * @package App
 */
class WatchList extends Model
{
    /**
     * Provides access to the related user to this watchList
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo('App\User');
    }

    /**
     * Provides access to the related movies to this watchList
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function movies() {
        return $this->belongsToMany('App\Movie', 'watch_list_movies', 'watch_list_id', 'movie_id');
    }
}
