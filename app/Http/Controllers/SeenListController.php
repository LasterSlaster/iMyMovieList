<?php

namespace App\Http\Controllers;

use App\SeenListMovie;
use App\SeenList;
use App\UserMovieRating;
use App\WatchListMovie;
use App\WatchList;
use App\Movie;
use App\User;
use App\Http\Resources\SeenListCollection;
use App\Http\Resources\WatchListMovieCollection;
use App\Http\Resources\SeenListMovieCollection;
use App\Http\Resources\SeenListMovieResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JWTAuth;

/**
 * Class SeenListController - Controller for requests to seenList resources
 * @package App\Http\Controllers
 */
class SeenListController extends Controller
{
    /**
     * Return a listing of the seenList resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new SeenListCollection(SeenList::paginate(20));
    }

    /**
     * Store a newly created seenList resource in storage.
     * Or update a seenList resource if the resource already exists.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $nickname
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $nickname)
    {
        $this->validate($request, [
            'movie_data' => 'required',
            'movie_code' => 'required',
            'rating' => 'required|integer|max:5|min:1'
        ]);

        $authUser = JWTAuth::parseToken()->toUser();

        if ($authUser->nickname != $nickname)
            return Response::create('Not authorized to access this resource', 403);

        //TODO: refactor this part. Vounerable because different id for same movie
        $user = User::where('nickname', $nickname)->firstOrFail();
        $seenList = SeenList::where('user_id', $user->id)->firstOrFail();

        $movie = Movie::where('movie_code', $request->movie_code)->first();

        if (is_null($movie)) {
            $movie = new Movie();
            $movie->movie_code = $request->movie_code;
            $movie->movie_data = $request->movie_data;
            $movie->save();
        }

        $rating = UserMovieRating::where('user_id', $user->id)->where('movie_id', $movie->id)->first();

        if (is_null($rating)) {
            $rating = new UserMovieRating();
            $rating->user_id = $user->id;
            $rating->movie_id = $movie->id;
        }
        $rating->rating = $request->rating;
        $rating->save();

        $seenListMovie = SeenListMovie::where('seen_list_id', $seenList->id)->where('movie_id', $movie->id)->first();
        if (!is_null($seenListMovie))
            return Response::create('Resource is already present use PUT to update', 405)->header('Allow', 'PUT');

        $seenListMovie = new SeenListMovie();
        $seenListMovie->seen_list_id = $seenList->id;
        $seenListMovie->movie_id = $movie->id;
        $seenListMovie->save();

        //Check if movie is already in watchlist and remove
        $watchList = watchList::where('user_id', $user->id)->first();
        $watchListMovie = WatchListMovie::where('watch_list_id', $watchList->id)->where('movie_id', $movie->id)->first();

        if (!is_null($watchListMovie))
            $watchListMovie->delete();

        return (new WatchListMovieCollection(WatchListMovie::where('watch_list_id', $watchList->id)->orderBy('created_at', 'desc')->paginate(20)))->response()->setStatusCode(201)->header('location', url()->full()."/".$movie->movie_code);;
    }

    /**
     * Return the specified seenList resource for a certain user.
     *
     * @param  string $nickname
     * @return \Illuminate\Http\Response
     */
    public function showList($nickname)
    {
        //Validation
        $seenList = User::where('nickname', $nickname)->firstOrFail()->seenList;

        if (is_null($seenList))
            return Response::create('No such resource!',404);

        return new SeenListMovieCollection(SeenListMovie::where('seen_list_id',$seenList->id)->orderBy('created_at', 'desc')->paginate(20));
    }

    /**
     * Return the specified seenList resource for a certain movie.
     *
     * @param  string $nickname
     * @param  string $movie_code
     * @return \Illuminate\Http\Response
     */
    public function showMovie($nickname, $movie_code) {
        //Validation
        $seenList = User::where('nickname', $nickname)->firstOrFail()->seenList;

        if (is_null($seenList))
            return Response::create('No such resource!',404);

        $movie = Movie::where('movie_code', $movie_code)->firstOrFail();

        return new SeenListMovieResource(SeenListMovie::where('seen_list_id',$seenList->id)->where('movie_id', $movie->id)->firstOrFail());
    }

    /**
     * Remove the specified seenList resource from storage.
     *
     * @param string $nickname
     * @param string $movie_code
     * @return \Illuminate\Http\Response
     */
    public function destroy($nickname, $movie_code)
    {
        $authUser = JWTAuth::parseToken()->toUser();

        if ($authUser->nickname != $nickname)
            return Response::create('Not authorized to access this resource', 403);

        $user = User::where('nickname', $nickname)->firstOrFail();
        $seenList = SeenList::where('user_id', $user->id)->firstOrFail();
        $movie = Movie::where('movie_code', $movie_code)->firstOrFail();
        $seenListMovie = SeenListMovie::where('seen_list_id', $seenList->id)->where('movie_id', $movie->id)->firstOrFail();
        $rating = UserMovieRating::where('user_id', $user->id)->where('movie_id', $movie->id)->firstOrFail();

        $seenListMovie->delete();
        $rating->delete();

        return (new SeenListMovieCollection(SeenListMovie::where('seen_list_id', $seenList->id)->orderBy('created_at', 'desc')->paginate(20)))->response()->setStatusCode(200);
    }
}
