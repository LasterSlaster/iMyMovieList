<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User represents a model of the user table
 *
 * @package App
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nickname', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Set default values for table attributes
     *
     * @var array
     */
    protected $attributes = [
        'role' => 'user'
    ];

    /**
     * Provides access to the related seenList to this user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function seenList() {
        return $this->hasOne('App\SeenList');
    }

    /**
     * Provides access to the related watchList to this user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function watchList() {
        return $this->hasOne('App\WatchList');
    }

    /**
     * Provides access to the related userMovieRatings to this user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userMovieRatings() {
        return $this->hasMany('App\UserMovieRating');
    }

    /**
     * Provides access to the related comments to this user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments() {
        return $this->hasMany('App\Comment');
    }


}
