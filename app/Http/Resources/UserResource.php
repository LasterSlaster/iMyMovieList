<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use App\SeenList;
use App\WatchList;
use App\SeenListMovie;
use App\WatchListMovie;

/**
 * Class UserResource for Collection to JSON conversion
 * @package App\Http\Resources
 */
class UserResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // Retrieve a count of all movies in a seenList for a user
        $seenList = SeenList::where('user_id', $this->id)->first();
        //$seenListMovieCount = $seenList->movies()->count(); //TODO: Check if its possible to call the count function at this point
        $seenListMovieCount = SeenListMovie::where('seen_list_id', $seenList->id)->count();

        // Retrieve a count of all movies in a watchList for a user
        $watchList = WatchList::where('user_id', $this->id)->first();
        //$watchListMovieCount = $watchList->movies()->count();
        $watchListMovieCount = WatchListMovie::where('watch_list_id', $watchList->id)->count();

        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'nickname' => $this->nickname,
            'role' => $this->role,
            'watchlist' => url('/')."/api/users/".$this->nickname."/watchlist", //Generate URL to related watchList resource
            'seenlist' => url('/')."/api/users/".$this->nickname."/seenlist", //Generate URL to related seenList resource
            'seenListCount' => $seenListMovieCount,
            'watchListCount' => $watchListMovieCount
        ];
    }
}
