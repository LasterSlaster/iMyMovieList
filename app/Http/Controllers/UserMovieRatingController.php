<?php

namespace App\Http\Controllers;

use App\UserMovieRating;
use App\HTTP\Resources\UserMovieRatingResource;
use Illuminate\Http\Request;

class UserMovieRatingController extends Controller
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
        $userMovieRating = new UserMovieRating();
        $userMovieRating->user_id = $request->user_id;
        $userMovieRating->movie_id = $request->movie_id;
        $userMovieRating->rating = $request->rating;
        $userMovieRating->save();

        return new UserMovieRatingResource($userMovieRating);
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
        $userMovieRating = UserMovieRating::where('user_id', $user_id)->where('movie_id', $movie_id)->findOrFail();

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
        $userMovieRating = UserMovieRating::where('user_id', $user_id)->where('movie_id', $movie_id);

        if ($userMovieRating != null) {
            $userMovieRating->rating = $request->rating;
        } else {
            $userMovieRating = new UserMovieRating();
            $userMovieRating->user_id = $user_id;
            $userMovieRating->movie_id = $movie_id;
            $userMovieRating->rating = $request->rating;
            $userMovieRating->save();
        }
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
