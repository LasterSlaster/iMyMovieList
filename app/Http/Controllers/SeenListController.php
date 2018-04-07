<?php

namespace App\Http\Controllers;

use App\SeenListMovie;
use Illuminate\Http\Request;

class SeenListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $seenList = DB::table('seen_list_movies')->join('seen_lists', 'seen_list_movies.seen_list_id', '=', 'seen_lists.id')->join('movies', 'seen_list_movies.movie_id', '=', 'movies.id')->where('seen_lists.user_id', $user_id)->get();

        return new MovieCollection($seenList.paginate(20));
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
        //Check if the movie is in watch list and remove it
        $movie = Movie::find($movie_id);
        if ($movie == null) {
            $movie = new Movie;
            $movie->movie_code = $movie_id;
            $movie->movie_data = $request->movie_data;
        }

        $seenList = SeenList::where('user_id', $user_id)->get();

        $seenListMovie = SeenListMovie::where('seen_list_id', $seenList->id)->where('movie_id', $movie_id)->get();

        if ($seenListMovie == null) {
            $seenListMovie = new SeenListMovie();
            $seenListMovie->seen_list_id = $seenList->id;
            $seenListMovie->movie_id = $movie_id;
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
        $seenList = SeenList::where('user_id', $user_id); //TODO: User more destinct primary keys
        //TODO: Merge Transactions
        $seenListMovie = SeenListMovie::where('seen_list_id', $seenList->id)->where('movie_id', $movie_id)->findOrFail();
        $seenListMovie->destroy();

        return Movie::find($movie_id);
    }
}
