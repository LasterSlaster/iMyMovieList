<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

/**
 * Class SeenListMovieResource for Collection to JSON conversion
 * @package App\Http\Resources
 */
class SeenListMovieResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'movie_code' => $this->movie->movie_code,
            'movie_data' => $this->movie->movie_data,
            'created_at' => $this->created_at
        ];
    }
}
