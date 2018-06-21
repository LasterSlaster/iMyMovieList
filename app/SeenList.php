<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SeenList represents a model of the seenList table
 *
 * @package App
 */
class SeenList extends Model
{
    /**
     * Provides access to the related user to this seenList
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo('App\User');
    }

    /**
     * Provides access to the related movies to this seenList
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function movies() {
        return $this->belongsToMany('App\Movie', 'seen_list_movies', 'seen_list_id', 'movie_id');
    }
}
