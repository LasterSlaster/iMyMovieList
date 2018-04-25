<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use App\SeenList;
use App\WatchList;

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
        $seenListMovieCount = SeenListMovie::where('seenList_id', $seenList->id)->count();

        $watchList = WatchList::where('user_id', $this->id)->first();
        //$watchListMovieCount = $watchList->movies()->count();
        $watchListMovieCount = WatchListMovie::where('watchList_id', $watchList->id)->count();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'surname' => $this->surname,
            'role' => $this->role,
            'seenListCount' => $seenListMovieCount,
            'watchListCount' => $watchListMovieCount
        ];
    }
}
