<?php

namespace App\Http\Controllers;

use App\Http\Resources\MovieCollection;
use App\Http\Resources\MovieResource;
use Illuminate\Http\Request;
use App\Movie;
use Illuminate\Http\Response;
use JWTAuth;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new MovieCollection(Movie::paginate(20));
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
        if (is_null($request->movie_code) || is_null($request->movie_data))
            return Response::create('JSON body must contain attributes movie_code and movie_data', 422);
        //TODO: Validate movie_code and movie_data for semantics

        $movie = new Movie();
        $movie->movie_code = $request->movie_code;
        $movie->movie_data = $request->movie_data;
        $movie->save();

        return (new MovieResource($movie))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Movie $movie
     * @return \Illuminate\Http\Response
     */
    public function show($movie_code)
    {
        return new MovieResource(Movie::where('movie_code', $movie_code)->firstOrFail());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Movie $movie
     * @return \Illuminate\Http\Response
     */
    public function edit(Movie $movie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Movie $movie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $movie_code)
    {
        //Validation
        if (is_null($request->movie_code)|| is_null($request->movie_data))
            return Response::create('JSON body must contain attributes movie_code and movie_data', 422);
        //TODO: Validate movie_code and movie_data for semantics

        $movie = Movie::where('movie_code', $movie_code)->first();

        if (is_null($movie)) {
            $movie = new Movie();
        }
        $movie->movie_code = $request->movie_code;
        $movie->movie_data = $request->movie_data;
        $movie->save();

        return (new MovieResource($movie))->response()->setStatusCode(201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Movie $movie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movie $movie)
    {
        //
    }
}
