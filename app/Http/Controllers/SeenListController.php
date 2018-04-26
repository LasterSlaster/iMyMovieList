<?php

namespace App\Http\Controllers;

use App\SeenListMovie;
use App\SeenList;
use App\Movie;
use App\Http\Resources\MovieResource;
use App\Http\Resources\MovieCollection;
use App\WatchListMovie;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\SeenListCollection;
use App\User;
use JWTAuth;

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
        //Validation
        $authUser = JWTAuth::parseToken()->toUser();

        if ($authUser->id != $user_id)
            return Response::create('Not authorized to access this resource', 403);

        //$seenList = DB::table('seen_list_movies')->join('seen_lists', 'seen_list_movies.seen_list_id', '=', 'seen_lists.id')->join('movies', 'seen_list_movies.movie_id', '=', 'movies.id')->where('seen_lists.user_id', $user_id)->get();
        $seenList = User::find($user_id)->seenList;

        if ($seenList == null)
            return Response::create('No such resource!',404);

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
        //TODO: Rewrite this method!!!

        //Validation
        $authUser = JWTAuth::parseToken()->toUser();

        if ($authUser->id != $user_id)
            return Response::create('Not authorized to access this resource', 403);

        if ($request->movie_id != $movie_id)
            return Response::create('json attribute movie_id and URL keyare not the same!',400);

        if ($request->movie_data != '') {
            //TODO: validate json content
        } else {
            return Response::create('attribute movie_data is missing or empty', 400);
        }

        $movie = Movie::find($movie_id);

        if ($movie == null) {
            $movie = new Movie;
        }

        $movie->movie_code = $movie_id;
        $movie->movie_data = $request->movie_data;
        $movie->save();

        $seenList = SeenList::where('user_id', $user_id)->first();

        if ($seenList == null)
            return Response::create('no such user', 404);

        $seenListMovie = SeenListMovie::where('seen_list_id', $seenList->id)->where('movie_id', $movie_id)->first();

        if ($seenListMovie == null) {
            $seenListMovie = new SeenListMovie();
            $seenListMovie->seen_list_id = $seenList->id;
            $seenListMovie->movie_id = $movie_id;
            $seenListMovie->save();
        }

        //Check if movie is already in watchlist and remove
        $watchList = WatchList::where('user_id', $user_id)->first();
        $watchListMovie = WatchListMovie::where('watch_list_id', $watchList)->where('movie_id', $movie_id)->first();
        if ($watchListMovie != null)
            $watchListMovie->delete();

        //TODO: implement better response
        return (new MovieResource($movie))->response()->setStatusCode(201);
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
        $authUser = JWTAuth::parseToken()->toUser();

        if ($authUser->id != $user_id)
            return Response::create('Not authorized to access this resource', 403);


        $seenList = SeenList::where('user_id', $user_id)->first(); //TODO: User more destinct primary keys

        if ($seenList == null)
            return Response::create('no such user', 404);

        //TODO: Merge Transactions
        $seenListMovie = SeenListMovie::where('seen_list_id', $seenList->id)->where('movie_id', $movie_id)->first();

        if ($seenListMovie == null)
            return Response::create('no such movie in watch list', 404);

        $movie = Movie::where('movie_id', $movie_id)->first();
        $seenListMovie->delete();

        return (new MovieResource($movie))->response()->setStatusCode(200);
    }
}
