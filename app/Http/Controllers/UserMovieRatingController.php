<?php

namespace App\Http\Controllers;

use App\UserMovieRating;
use App\Http\Resources\UserMovieRatingResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JWTAuth;

class UserMovieRatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UserMovieRatingResource::paginate(20);
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
        //Validation
        $user = User::where('nickname', $request->nickname)->firstOrFail();
        if (is_null($request->movie_id) || is_null($request->nickname))
            return Response::create('JSON body must contain attributes movie_id, nickname and rating', 422);

        $movie = Movie::where('movie_code', $request->movie_code)->first();
        if (is_null($movie))
            return Response::create('Movie id is not valid', 422);

        //TODO: Validate that rating is an interger within the range
        $authUser = JWTAuth::parseToken()->toUser();

        if ($authUser->nickname != $request->nickname)
            return Response::create('Not authorized to access this resource', 403);

        $userMovieRating = new UserMovieRating();
        $userMovieRating->user_id = $user->id;
        $userMovieRating->movie_id = $movie->id;
        $userMovieRating->rating = $request->rating;
        $userMovieRating->save();
        //TODO: Return the new Resource URL
        return (new UserMovieRatingResource($userMovieRating))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $user_id
     * @param int $movie_id
     * @return \Illuminate\Http\Response
     */
    public function show($nickname, $movie_code)
    {
        $user = User::where('nickname', $nickname)->firstOrFail();
        $movie = Movie::where('movie_code', $movie_code)->firstOrFail();
        $userMovieRating = UserMovieRating::where('user_id', $user->id)->where('movie_id', $movie->id)->first();

        if (is_null($userMovieRating))
            return Response::create('Specified resource not found', 404);

        return new UserMovieRatingResource($userMovieRating);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserMovieRating  $userMovieRating
     * @return \Illuminate\Http\Response
     */
    public function edit(UserMovieRating $userMovieRating)
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
    public function update(Request $request, $nickname, $movie_code)
    {
        //Validation
        $authUser = JWTAuth::parseToken()->toUser();

        if ($authUser->id != $nickname)
            return Response::create('Not authorized to access this resource', 403);
        $user = User::where('nickname', $nickname)->firstOrFail();
        if ($request->nickname != $nickname && $request->movie_code != $movie_code)
            return Response::create('URL parameter movie_id and nickname must be equal to json body attributes', 422);

        if (is_null($request->rating))
            return Response::create('JSON attribute rating must not be null', 422);

        $movie = Movie::where('movie_code', $movie_code)->firstOrFail();
        //TODO: Validate that rating is an interger within the range
        $userMovieRating = UserMovieRating::where('user_id', $user->id)->where('movie_id', $movie->id)->first();

        if (is_null($userMovieRating)) {
            $userMovieRating = new UserMovieRating();
        }
        $userMovieRating->user_id = $user->id;
        $userMovieRating->movie_id = $movie->id;
        $userMovieRating->rating = $request->rating;
        $userMovieRating->save();

        return (new UserMovieRatingResource($userMovieRating))->response()->setStatusCode(201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserMovieRating  $userMovieRating
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserMovieRating $userMovieRating)
    {
        //
    }
}
