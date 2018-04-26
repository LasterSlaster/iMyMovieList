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
        if ($request->movie_id == null || $request->user_id == null)
            return Response::create('JSON body must contain attributes movie_id, user_id and rating', 422);
        if (Movie::find($request->user_id) == null || User::find($request->movie_id) == null)
            return Response::create('User or movie id is not valid', 422);

        $authUser = JWTAuth::parseToken()->toUser();

        if ($authUser->id != $request->user_id)
            return Response::create('Not authorized to access this resource', 403);

        //TODO: Validate that rating is an interger within the range

        $userMovieRating = new UserMovieRating();
        $userMovieRating->user_id = $request->user_id;
        $userMovieRating->movie_id = $request->movie_id;
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
    public function show($user_id, $movie_id)
    {
        $userMovieRating = UserMovieRating::where('user_id', $user_id)->where('movie_id', $movie_id)->first();

        if ($userMovieRating == null)
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
    public function update(Request $request, $user_id, $movie_id)
    {
        //Validation
        $authUser = JWTAuth::parseToken()->toUser();

        if ($authUser->id != $user_id)
            return Response::create('Not authorized to access this resource', 403);

        if ($request->user_id != $user_id && $request->movie_id != $movie_id)
            return Response::create('URL parameter movie_id and user_id must be equal to json body attributes', 422);

        if ($request->rating == null)
            return Response::create('JSON attribute rating must not be null', 422);
        //TODO: Validate that rating is an interger within the range
        $userMovieRating = UserMovieRating::where('user_id', $user_id)->where('movie_id', $movie_id)->first();

        if ($userMovieRating == null) {
            $userMovieRating = new UserMovieRating();
        }
        $userMovieRating->user_id = $request->user_id;
        $userMovieRating->movie_id = $request->movie_id;
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
