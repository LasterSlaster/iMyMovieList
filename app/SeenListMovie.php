<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class SeenListMovie represents a model of the seenListMovie table
 *
 * @package App
 */
class SeenListMovie extends Pivot
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
    protected $table = 'seen_list_movies';

    /**
     * Provides access to the related movie to this seenList
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function movie() {
        return $this->belongsTo('App\Movie');
    }
}
