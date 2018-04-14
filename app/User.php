<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function seenList() {
        return $this->hasOne('App\SeenList');
    }

    public function watchList() {
        return $this->hasOne('App\WatchList');
    }

    public function userMovieRatings() {
        return $this->hasMany('App\UserMovieRating');
    }

    public function comments() {
        return $this->hasMany('App\Comment');
    }


}
