<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * Class SeenListMovieCollection for Collection to JSON conversion
 * @package App\Http\Resources
 */
class SeenListMovieCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => SeenListMovieResource::collection($this->collection)
        ];
    }
}
