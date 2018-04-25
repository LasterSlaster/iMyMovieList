<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class CommentResource extends Resource
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
            'id' => $this->id,
            'user' => json_encode([
                'id' => $this->user()->id,
                'name' => $this->user()->name,
                'surname' => $this->user()->surname
            ]),
            'movie' => json_encode([
                'id' => $this->movie()->id,
                'movie_code' => $this->movie()->movie_code
            ]),
            'comment_text' => $this->comment_text
        ];
    }
}
