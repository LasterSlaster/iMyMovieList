<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserMovieRating represents a model of the userMovieRating table
 *
 * @package App
 */
class UserMovieRating extends Model
{
    /**
     * Provides access to the related user to this UserMovieRating
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo('App\User');
    }

    /**
     * Provides access to the related movies to this UserMovieRating
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function movie() {
        return $this->belongsTo('App\Movie');
    }
}
