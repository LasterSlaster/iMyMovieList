<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeenList extends Model
{
    public function user() {
        return $this->belongsTo('App\User');
    }

    public function movies() {
        return $this->belongsToMany('App\Movie', 'seen_list_movies', 'seen_list_id', 'movie_id');
    }
}
