<?php

namespace App\Http\Controllers;

use App\SeenListMovie;
use App\SeenList;
use App\WatchListMovie;
use App\WatchList;
use App\Movie;
use App\User;
use App\Http\Resources\MovieResource;
use App\Http\Resources\MovieCollection;
use App\Http\Resources\SeenListCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
    public function store(Request $request, $nickname)
    {
        //TODO: Rewrite this method!!!

        //Validation
        //TODO:Validate existence of request attributes
        $authUser = JWTAuth::parseToken()->toUser();

        if ($authUser->nickname != $nickname)
            return Response::create('Not authorized to access this resource', 403);

        if ($request->movie_data != '') {
            //TODO: validate json content
        } else {
            return Response::create('attribute movie_data is missing or empty', 422);
        }

        if ($request->movie_code == '')
            return Response::create('attribute movie_code is missing or empty', 422);

        //TODO: refactor this part. Vounerable because different id for same movie
        $user = User::where('nickname', $nickname)->firstOrFail();
        $seenList = SeenList::where('user_id', $user->id)->first();
        if (is_null($seenList))
            return Response::create('no such list', 404);

        if (is_null($movie = Movie::where('movie_code', $request->movie_code)->first())) {
            $movie = new Movie();
            $movie->movie_code = $request->movie_code;
            $movie->movie_data = $request->movie_data;
            $movie->save();
        }

        $seenListMovie = SeenListMovie::where('seen_list_id', $seenList->id)->where('movie_id', $movie->id)->first();
        if (!is_null($seenListMovie))
            return Response::create('Resource is already present use PUT to update', 400);

        $seenListMovie = new SeenListMovie();
        $seenListMovie->seen_list_id = $seenList->id;
        $seenListMovie->movie_id = $movie->id;
        $seenListMovie->save();

        //Check if movie is already in watchlist and remove
        $watchList = watchList::where('user_id', $user->id)->first();
        $watchListMovie = WatchListMovie::where('watch_list_id', $watchList)->where('movie_id', $request->id)->first();

        if (!is_null($watchListMovie))
            $watchListMovie->delete();

        //TODO: implement better response
        return (new MovieResource($movie))->response()->setStatusCode(201)->header('location', url()->full()."/".$movie->movie_code);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $user_id
     * @return \Illuminate\Http\Response
     */
    public function show($nickname)
    {
        //Validation
        $authUser = JWTAuth::parseToken()->toUser();

        if ($authUser->nickname != $nickname)
            return Response::create('Not authorized to access this resource', 403);

        //$seenList = DB::table('seen_list_movies')->join('seen_lists', 'seen_list_movies.seen_list_id', '=', 'seen_lists.id')->join('movies', 'seen_list_movies.movie_id', '=', 'movies.id')->where('seen_lists.user_id', $user_id)->get();
        $seenList = User::where('nickname', $nickname)->firstOrFail()->seenList;

        if (is_null($seenList))
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
    public function update(Request $request, $user_id, $movie_code)
    {
        //TODO: Think about removing this method
        //TODO: Rewrite this method!!!

        //Validation
        $authUser = JWTAuth::parseToken()->toUser();

        if ($authUser->id != $user_id)
            return Response::create('Not authorized to access this resource', 403);

        if ($request->movie_code != $movie_code)
            return Response::create('json attribute movie_code and URL keyare not the same!',400);

        if ($request->movie_data != '') {
            //TODO: validate json content
        } else {
            return Response::create('attribute movie_data is missing or empty', 400);
        }

        $movie = Movie::where('movie_code', $movie_code)->first();

        if (is_null($movie)) {
            return Response::create('Resource not found. Use POST to add a movie to the list', 404);
        }

        $movie->movie_code = $movie->code;
        $movie->movie_data = $request->movie_data;
        $movie->save();

        $seenList = SeenList::where('user_id', $user_id)->first();

        if (is_null($seenList))
            return Response::create('no such user', 404);

        $seenListMovie = SeenListMovie::where('seen_list_id', $seenList->id)->where('movie_id', $movie->id)->first();

        if (is_null($seenListMovie)) {
            $seenListMovie = new SeenListMovie();
            $seenListMovie->seen_list_id = $seenList->id;
            $seenListMovie->movie_id = $movie->id;
            $seenListMovie->save();
        }

        //Check if movie is already in watchlist and remove
        $watchList = WatchList::where('user_id', $user_id)->first();
        $watchListMovie = WatchListMovie::where('watch_list_id', $watchList)->where('movie_id', $movie->id)->first();
        if (!is_null($watchListMovie))
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
    public function destroy($nickname, $movie_code)
    {
        $authUser = JWTAuth::parseToken()->toUser();

        if ($authUser->nickname != $nickname)
            return Response::create('Not authorized to access this resource', 403);

        $user = User::where('nickname', $nickname)->firstOrFail();
        $seenList = SeenList::where('user_id', $user->id)->first(); //TODO: User more destinct primary keys

        if (is_null($seenList))
            return Response::create('no such list', 404);

        $movie = Movie::where('movie_code', $movie_code)->first();
        if (is_null($movie))
            return Response::create('No such movie', 404);
        //TODO: Merge Transactions
        $seenListMovie = SeenListMovie::where('seen_list_id', $seenList->id)->where('movie_id', $movie->id)->first();

        if (is_null($seenListMovie))
            return Response::create('no such movie in watch list', 404);

        $seenListMovie->delete();

        return (new MovieResource($movie))->response()->setStatusCode(200);
    }
}
