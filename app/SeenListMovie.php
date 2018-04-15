<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class SeenListMovie extends Pivot
{
    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'seen_list_movies';
}
