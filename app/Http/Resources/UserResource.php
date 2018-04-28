<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use App\SeenList;
use App\WatchList;
use App\SeenListMovie;
use App\WatchListMovie;

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
        $seenList = SeenList::where('user_id', $this->id)->first();
        //$seenListMovieCount = $seenList->movies()->count(); //TODO: Check if its possible to call the count function at this point
        $seenListMovieCount = SeenListMovie::where('seen_list_id', $seenList->id)->count();

        $watchList = WatchList::where('user_id', $this->id)->first();
        //$watchListMovieCount = $watchList->movies()->count();
        $watchListMovieCount = WatchListMovie::where('watch_list_id', $watchList->id)->count();

        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'nickname' => $this->nickname,
            'role' => $this->role,
            'watchlist' => url('/')."/api/users/".$this->nickname."/watchlist",
            'seenlist' => url('/')."/api/users/".$this->nickname."/seenlist",
            'seenListCount' => $seenListMovieCount,
            'watchListCount' => $watchListMovieCount
        ];
    }
}
