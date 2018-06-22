<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

/**
 * Class WatchListMovieResource for Collection to JSON conversion
 * @package App\Http\Resources
 */
class WatchListMovieResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user = $this->watchlist->user;
        $movie = $this->movie;

        return [
            'movie_code' => $this->movie->movie_code,
            'movie_data' => json_decode($this->movie->movie_data),
            'created_at' => $this->created_at
        ];
    }
}
