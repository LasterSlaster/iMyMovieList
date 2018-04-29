<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\WatchListCollection;
use App\Http\Resources\MovieCollection;
use App\Http\Resources\WatchListMovieResource;
use App\Http\Resources\WatchListMovieCollection;
use App\WatchList;
use App\SeenList;
use App\WatchListMovie;
use App\SeenListMovie;
use App\Movie;
use App\User;
use JWTAuth;

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
        $watchList = WatchList::where('user_id', $user->id)->first();
        if (is_null($watchList))
            return Response::create('no such list', 404);

        if (is_null($movie = Movie::where('movie_code', $request->movie_code)->first())) {
            $movie = new Movie();
            $movie->movie_code = $request->movie_code;
            $movie->movie_data = $request->movie_data;
            $movie->save();
        }
        $watchListMovie = WatchListMovie::where('watch_list_id', $watchList->id)->where('movie_id', $movie->id)->first();
        if (!is_null($watchListMovie))
            return Response::create('Resource is already present use PUT to update', 405)->header('Allow', 'PUT');

        $watchListMovie = new WatchListMovie();
        $watchListMovie->watch_list_id = $watchList->id;
        $watchListMovie->movie_id = $movie->id;
        $watchListMovie->save();

        //Check if movie is already in watchlist and remove
        $seenList = SeenList::where('user_id', $user->id)->first();
        $seenListMovie = SeenListMovie::where('seen_list_id', $seenList->id)->where('movie_id', $movie->id)->first();

        if (!is_null($seenListMovie))
            $seenListMovie->delete();

        return new WatchListMovieResource($watchListMovie);
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

        //$watchList = DB::table('watch_list_movies')->join('watch_lists', 'watch_list_movies.watch_list_id', '=', 'watch_lists.id')->join('movies', 'watch_list_movies.movie_id', '=', 'movies.id')->where('watch_lists.user_id', $user_id)->paginate(20);

        $watchList = User::where('nickname', $nickname)->firstOrFail()->watchList;

        if (is_null($watchList))
            return Response::create('No such resource!',404);
        //TODO: Replace movie timestamps with the timestamps from table watch_list_movies

        return new WatchListMovieCollection(WatchListMovie::where('watch_list_id',$watchList->id)->orderBy('created_at', 'desc')->paginate(20));
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
    public function update(Request $request, $user_id, $movie_code)
    {
        //TODO: Think about removing this method and use a idempotent post method
        //TODO: Rewrite this method

        //Validation
        $authUser = JWTAuth::parseToken()->toUser();

        if ($authUser->id != $user_id)
            return Response::create('Not authorized to access this resource', 403);

        if ($request->movie_code != $movie_code)
             return Response::create('json attribute movie_id and URL key are not the same!',422);

         if ($request->movie_data != '') {
             //TODO: validate json content
         } else {
             return Response::create('attribute movie_data is missing or empty', 422);
         }

        $movie = Movie::where($movie_code)->first();

        if (is_null($movie)) {
            return Response::create('Resource not found. Use POST to add a movie to the list', 404);
        }

        $movie->movie_code = $movie_code;
        $movie->movie_data = $request->movie_data;
        $movie->save();

        $watchList = WatchList::where('user_id', $user_id)->first();

        if (is_null($watchList))
            return Response::create('no such user', 404);

        $watchListMovie = WatchListMovie::where('watch_list_id', $watchList->id)->where('movie_id', $movie->id)->get();

        if (is_null($watchListMovie)) {
            $watchListMovie = new WatchListMovie();
            $watchListMovie->seen_list_id = $watchList->id;
            $watchListMovie->movie_id = $movie->id;
            $watchListMovie->save();
        }

        //Check if movie is already in watchlist and remove
        $seenList = SeenList::where('user_id', $user_id)->first();
        $seenListMovie = SeenListMovie::where('seen_list_id', $seenList)->where('movie_id', $movie->id)->first();

        if (!is_null($seenListMovie))
            $seenListMovie->delete();

        return new WatchListMovieResource($watchListMovie);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $user_id
     * @param int $movie_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($nickname, $movie_code)
    {
        //Validation
        $authUser = JWTAuth::parseToken()->toUser();

        if ($authUser->nickname != $nickname)
            return Response::create('Not authorized to access this resource', 403);

        $user = User::where('nickname', $nickname)->firstOrFail();
        $watchList = WatchList::where('user_id', $user->id)->first(); //TODO: User more destinct primary keys

        if (is_null($watchList))
            return Response::create('no such user', 404);

        $movie = Movie::where('movie_code', $movie_code)->first();
        if(is_null($movie))
            return Response::create('No such movie', 404);
        //TODO: Merge Transactions
        $watchListMovie = WatchListMovie::where('watch_list_id', $watchList->id)->where('movie_id', $movie->id)->first();

        if (is_null($watchListMovie))
            return Response::create('no such movie in watch list', 404);

        $watchListMovie->delete();

        //return new watchlist
        $newWatchList = $watchList->movies()->paginate(20);

        return (new MovieCollection($newWatchList))->response()->setStatusCode(200);
    }
}
