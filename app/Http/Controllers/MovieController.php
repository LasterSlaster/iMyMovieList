<?php

namespace App\Http\Controllers;

use App\Http\Resources\MovieCollection;
use App\Http\Resources\MovieResource;
use Illuminate\Http\Request;
use App\Movie;
use JWTAuth;

/**
 * Class MovieController - Controller for requests to movie resources
 * @package App\Http\Controllers
 */
class MovieController extends Controller
{
    /**
     * Return a listing of the movie resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new MovieCollection(Movie::paginate(20));
    }

    /**
     * Store a newly created movie resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'movie_code' => 'required',
            'movie_data' => 'required'
        ]);

        $movie = new Movie();
        $movie->movie_code = $request->movie_code;
        $movie->movie_data = $request->movie_data;
        $movie->save();

        return (new MovieResource($movie))->response()->setStatusCode(201)->header('location', url()->full()."/".$movie->movie_code);
    }

    /**
     * Return the specified movie resource.
     *
     * @param  string $movie_code
     * @return \Illuminate\Http\Response
     */
    public function show($movie_code)
    {
        return new MovieResource(Movie::where('movie_code', $movie_code)->firstOrFail());
    }


    /**
     * Update the specified movie resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $movie_code
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $movie_code)
    {
        $this->validate($request, [
            'movie_code' => 'required',
            'movie_data' => 'required'
        ]);

        $movie = Movie::where('movie_code', $movie_code)->first();

        if (is_null($movie)) {
            $movie = new Movie();
        }
        $movie->movie_code = $request->movie_code;
        $movie->movie_data = $request->movie_data;
        $movie->save();

        return (new MovieResource($movie))->response()->setStatusCode(201);
    }
}
