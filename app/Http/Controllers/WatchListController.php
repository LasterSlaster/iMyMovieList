<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\MovieCollection;
use App\Http\Resources\MovieResource;
use App\WatchList;
use App\WatchListMovie;
use App\Movie;
use App\User;
use App\Http\Resources\WatchListCollection;


/**
 * Class WatchListController
 * @package App\Http\Controllers
 */
class WatchListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new WatchListCollection(WatchList::paginate(20));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $user_id
     * @return \Illuminate\Http\Response
     */
    public function show($user_id)
    {
        //$watchList = DB::table('watch_list_movies')->join('watch_lists', 'watch_list_movies.watch_list_id', '=', 'watch_lists.id')->join('movies', 'watch_list_movies.movie_id', '=', 'movies.id')->where('watch_lists.user_id', $user_id)->paginate(20);
        $watchList = User::find($user_id)->watchList()->first();

        return new MovieCollection($watchList->movies()->paginate(20));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  WatchList $watchList
     * @return \Illuminate\Http\Response
     */
    public function edit(WatchList $watchList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $user_id
     * @param int $movie_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user_id, $movie_id)
    {
        //TODO: Rewrite this method
        $movie = Movie::find($movie_id);
        if ($movie == null) {
            $movie = new Movie;
            $movie->movie_code = $movie_id;
            $movie->movie_data = $request->movie_data;
            $movie->save();
        }

        $watchList = WatchList::where('user_id', $user_id)->get();

        $watchListMovie = WatchListMovie::where('watch_list_id', $watchList->id)->where('movie_id', $movie_id)->get();

        if ($watchListMovie == null) {
            $watchListMovie = new WatchListMovie();
            $watchListMovie->seen_list_id = $watchList->id;
            $watchListMovie->movie_id = $movie_id;
        }

        //TODO: implement better response
        return new MovieResource($movie);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $user_id
     * @param int $movie_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id, $movie_id)
    {
        $watchList = WatchList::where('user_id', $user_id); //TODO: User more destinct primary keys
        //TODO: Merge Transactions
        $watchListMovie = WatchListMovie::where('watch_list_id', $watchList->id)->where('movie_id', $movie_id)->findOrFail();
        $watchListMovie->destroy();

        return Movie::find($movie_id);
    }
}
