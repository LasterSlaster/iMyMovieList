<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\WatchListCollection;
use App\Http\Resources\WatchListMovieResource;
use App\Http\Resources\WatchListMovieCollection;
use App\WatchList;
use App\SeenList;
use App\WatchListMovie;
use App\SeenListMovie;
use App\Http\Resources\SeenListMovieCollection;
use App\Movie;
use App\User;
use JWTAuth;

/**
 * Class WatchListController - Controller for requests to watchList resources
 * @package App\Http\Controllers
 */
class WatchListController extends Controller
{
    /**
     * Return a listing of the watchList resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new WatchListCollection(WatchList::paginate(20));
    }

    /**
     * Store a newly created watchList resource in storage.
     * Or update the resource if it already exists.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $nickname
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $nickname)
    {
        $this->validate($request, [
            'movie_code' => 'required',
            'movie_data' => 'required',
        ]);

        $authUser = JWTAuth::parseToken()->toUser();

        if ($authUser->nickname != $nickname)
            return Response::create('Not authorized to access this resource', 403);

        $user = User::where('nickname', $nickname)->firstOrFail();
        $watchList = WatchList::where('user_id', $user->id)->firstOrFail();

        $movie = Movie::where('movie_code', $request->movie_code)->first();

        if (is_null($movie)) {
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

        return (new SeenListMovieCollection(SeenListMovie::where('seen_list_id', $seenList->id)->orderBy('created_at', 'desc')->paginate(20)))->response()->setStatusCode(201)->header('location', url()->full()."/".$movie->movie_code);
    }

    /**
     * Return the specified watchList resource for a certain user.
     *
     * @param  string $nickname
     * @return \Illuminate\Http\Response
     */
    public function showList($nickname)
    {
        //Validation
        $watchList = User::where('nickname', $nickname)->firstOrFail()->watchList;

        if (is_null($watchList))
            return Response::create('No such resource!',404);

        return new WatchListMovieCollection(WatchListMovie::where('watch_list_id',$watchList->id)->orderBy('created_at', 'desc')->paginate(20));
    }

    /**
     * Return the specified watchList resource for a certain movie.
     *
     * @param  string $nickname
     * @param  string $movie_code
     * @return \Illuminate\Http\Response
     */
    public function showMovie($nickname, $movie_code)
    {

        $watchList = User::where('nickname', $nickname)->firstOrFail()->watchList;

        if (is_null($watchList))
            return Response::create('No such resource!',404);

        $movie = Movie::where('movie_code', $movie_code)->firstOrFail();

        return new WatchListMovieResource(WatchListMovie::where('watch_list_id',$watchList->id)->where('movie_id', $movie->id)->firstOrFail());
    }


    /**
     * Remove the specified watchList resource from storage.
     *
     * @param  string %nickname
     * @param  string %movie_code
     * @return \Illuminate\Http\Response
     */
    public function destroy($nickname, $movie_code)
    {
        //Validation
        $authUser = JWTAuth::parseToken()->toUser();

        if ($authUser->nickname != $nickname)
            return Response::create('Not authorized to access this resource', 403);

        $user = User::where('nickname', $nickname)->firstOrFail();
        $watchList = WatchList::where('user_id', $user->id)->firstOrFail();
        $movie = Movie::where('movie_code', $movie_code)->firstOrFail();

        $watchListMovie = WatchListMovie::where('watch_list_id', $watchList->id)->where('movie_id', $movie->id)->firstOrFail();

        $watchListMovie->delete();

        return (new WatchListMovieCollection(WatchListMovie::where('watch_list_id', $watchList->id)->orderBy('created_at', 'desc')->paginate(20)))->response()->setStatusCode(200);
    }
}
