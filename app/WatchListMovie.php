<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class WatchListMovie representing a model of a watchListMovie table
 * @package App
 */
class WatchListMovie extends Pivot
{
    /**
     * Update timestamps automatically
     *
     * @var bool
     */
    public $timestamps = true;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'watch_list_movies';

    /**
     * Provides access to the related movie to this watchListMovie
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function movie() {
        return $this->belongsTo('App\Movie');
    }
}
