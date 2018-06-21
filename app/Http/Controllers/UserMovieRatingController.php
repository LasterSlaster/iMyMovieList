<?php

namespace App\Http\Controllers;

use App\UserMovieRating;
use App\Http\Resources\UserMovieRatingResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JWTAuth;
use App\User;
use App\Movie;

/**
 * Class UserMovieRatingController - Controller for requests to userMovieRating resources
 * @package App\Http\Controllers
 */
class UserMovieRatingController extends Controller
{
    /**
     * Return a listing of the userMovieRating resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UserMovieRatingResource::paginate(20);
    }

    /**
     * Store a newly created userMovieRating resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'movie_code' => 'required',
            'nickname' => 'required',
            'rating' => 'required|number|min:1|max:5'
        ]);

        $authUser = JWTAuth::parseToken()->toUser();
        $user = User::where('nickname', $request->nickname)->firstOrFail();
        $movie = Movie::where('movie_code', $request->movie_code)->firstOrFail();

        if ($authUser->nickname != $request->nickname)
            return Response::create('Not authorized to access this resource', 403);

        $userMovieRating = new UserMovieRating();
        $userMovieRating->user_id = $user->id;
        $userMovieRating->movie_id = $movie->id;
        $userMovieRating->rating = $request->rating;
        $userMovieRating->save();

        return (new UserMovieRatingResource($userMovieRating))->response()->setStatusCode(201)->header('location', url()->full()."/".$userMovieRating->id);
    }

    /**
     * Display the specified userMovieRating resource.
     *
     * @param  string $nickname
     * @param  string $movie_code
     * @return \Illuminate\Http\Response
     */
    public function show($nickname, $movie_code)
    {
        $user = User::where('nickname', $nickname)->firstOrFail();
        $movie = Movie::where('movie_code', $movie_code)->firstOrFail();
        $userMovieRating = UserMovieRating::where('user_id', $user->id)->where('movie_id', $movie->id)->firstOrFail();

        return new UserMovieRatingResource($userMovieRating);
    }

    /**
     * Update the specified userMovieRating resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $nickname
     * @param  string $movie_code
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $nickname, $movie_code)
    {
        //Validation
        $this->validate($request, [
            'movie_code' => 'required',
            'nickname' => 'required',
            'rating' => 'required|number|min:1|max:5'
        ]);

        $authUser = JWTAuth::parseToken()->toUser();

        $user = User::where('nickname', $nickname)->firstOrFail();

        if ($authUser->nickname != $nickname)
            return Response::create('Not authorized to access this resource', 403);

        if ($request->nickname != $nickname && $request->movie_code != $movie_code)
            return Response::create('URL parameter movie_id and nickname must be equal to json body attributes', 422);

        $movie = Movie::where('movie_code', $movie_code)->firstOrFail();

        if (is_null( $userMovieRating = UserMovieRating::where('user_id', $user->id)->where('movie_id', $movie->id)->first())) {
            $userMovieRating = new UserMovieRating();
        }
        $userMovieRating->user_id = $user->id;
        $userMovieRating->movie_id = $movie->id;
        $userMovieRating->rating = $request->rating;
        $userMovieRating->save();

        return (new UserMovieRatingResource($userMovieRating))->response()->setStatusCode(201);
    }
}
