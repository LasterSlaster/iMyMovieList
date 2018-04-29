<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\DB;

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
        return [
            'movie_code' => $this->movie->movie_code,
            'movie_data' => $this->movie->movie_data,
            'created_at' => $this->created_at
        ];
    }
}
