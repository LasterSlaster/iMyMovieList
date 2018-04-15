<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class WatchListMovie extends Pivot
{
    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'watch_list_movies';
}
