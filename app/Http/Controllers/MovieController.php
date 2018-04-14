<?php

namespace App\Http\Controllers;

use App\Http\Resources\MovieCollection;
use App\Http\Resources\MovieResource;
use Illuminate\Http\Request;
use App\Movie;

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
        $movie = new Movie();
        $movie->movie_code = $request->movie_code;
        $movie->movie_data = $request->movie_data;
        $movie->save();

        return new MovieResource($movie);
    }

    /**
     * Display the specified resource.
     *
     * @param  Movie $movie
     * @return \Illuminate\Http\Response
     */
    public function show(Movie $movie)
    {
        //TODO: Check if an error http is send when no movie is found or if null is returned
        return new MovieResource($movie);
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
    public function update(Request $request, Movie $movie)
    {
        if ($movie == null) {
            $movie = new Movie();
        }

        $movie->movie_code = $request->movie_code;
        $movie->movie_data = $request->movie_data;
        $movie->save();

        return new MovieResource($movie);
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
