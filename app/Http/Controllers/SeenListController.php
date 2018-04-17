<?php

namespace App\Http\Controllers;

use App\SeenListMovie;
use App\SeenList;
use App\Movie;
use App\Http\Resources\MovieResource;
use App\Http\Resources\MovieCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Resources\SeenListCollection;
use App\User;

class SeenListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new SeenListCollection(SeenList::paginate(20));
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
        //$seenList = DB::table('seen_list_movies')->join('seen_lists', 'seen_list_movies.seen_list_id', '=', 'seen_lists.id')->join('movies', 'seen_list_movies.movie_id', '=', 'movies.id')->where('seen_lists.user_id', $user_id)->get();
        $seenList = User::find($user_id)->seenList()->first();

        return new MovieCollection($seenList->movies()->paginate(20));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  SeenList $seenList
     * @return \Illuminate\Http\Response
     */
    public function edit(SeenList $seenList)
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
        //TODO:Check if the movie is in watch list and remove it
        //TODO: use pu only for update otherwiese fail
        $movie = Movie::find($movie_id);
        if ($movie == null) {
            $movie = new Movie;
            $movie->movie_code = $movie_id;
            $movie->movie_data = $request->movie_data;
            $movie->watch_total = 0;
            $movie->seen_total = 0;
            $movie->save();
        }

        $seenList = SeenList::where('user_id', $user_id)->first();

        $seenListMovie = SeenListMovie::where('seen_list_id', $seenList->id)->where('movie_id', $movie_id)->get();

        if ($seenListMovie == null) {
            $seenListMovie = new SeenListMovie();
            $seenListMovie->seen_list_id = $seenList->id;
            $seenListMovie->movie_id = $movie_id;
            $seenListMovie->save();
        }

        //TODO: implement better response
        return new MovieResource($movie);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $user_id
     * @param int $movie_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id, $movie_id)
    {
        $seenList = SeenList::where('user_id', $user_id)->first(); //TODO: User more destinct primary keys
        //TODO: Merge Transactions
        $seenListMovie = SeenListMovie::where('seen_list_id', $seenList->id)->where('movie_id', $movie_id)->first();
        $seenListMovie->delete();

        return new MovieResource($seenListMovie);
    }
}
