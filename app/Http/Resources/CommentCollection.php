<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use JWTAuth;
use App\Comment;

/**
 * Class CommentCollection for Collection to JSON conversion
 * @package App\Http\Resources
 */
class CommentCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }

    /*public function with($request) {
        $currentUser = JWTAuth::parseToken()->toUser();
        $userComment = Comment::where('user_id', $currentUser->id)->where('movie_id', );
        return [
            'user' => json_encode((new CommentResource($userComment)))
        ];
    }*/
}
