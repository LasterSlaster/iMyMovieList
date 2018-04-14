<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WatchList extends Model
{
    public function user() {
        return $this->belongsTo('App\User');
    }

    public function movies() {
        return $this->belongsToMany('App\Movie', 'watch_list_movies', 'watch_list_id', 'movie_id');
    }
}
