<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::post('/user/signup', 'UserController@signup');
Route::post('/user/signin', 'UserController@signin');

Route::middleware('auth.jwt')->group(function() {

    Route::get('/users', 'UserController@index');
    Route::get('/users/{nickname}', 'UserController@show');
    Route::patch('/users/{nickname}', 'UserController@update');
    Route::delete('/users/{nickname}', 'UserController@destroy');

    Route::get('/seenlists', 'SeenListController@index');
    Route::get('/users/{nickname}/seenlist/', 'SeenListController@show');
    Route::post('/users/{nickname}/seenlist/movies/', 'SeenListController@store');
    //Route::put('/users/{user_id}/seenlist/movies/{movie_id}', 'SeenListController@update');
    Route::delete('/users/{nickname}/seenlist/movies/{movie_id}', 'SeenListController@destroy');

    Route::get('/watchlists', 'WatchListController@index');
    Route::get('/users/{nickname}/watchlist/', 'WatchListController@show');
    Route::post('/users/{nickname}/watchlist/movies/', 'WatchListController@store');
    //Route::put('/users/{user_id}/watchlist/movies/{movie_id}', 'WatchListController@update');
    Route::delete('/users/{nickname}/watchlist/movies/{movie_id}', 'WatchListController@destroy');

    Route::get('/users/{nickname}/usermovieratings/movies/{movie_id}', 'UserMovieRatingController@show');
    Route::post('/users/{nickname}/usermovieratings/', 'UserMovieRatingController@store');
    Route::put('/users/{nickname}/usermovieratings/movies/{movie_id}', 'UserMovieRatingController@update');

    Route::get('/comments', 'CommentController@index');
    Route::get('/movies/{movie_id}/comments', 'CommentController@indexMovieComments');
    Route::get('/users/{nickname}/comments', 'CommentController@indexUserComments');
    Route::get('/comments/{comment}', 'CommentController@show');
    Route::post('/comments', 'CommentController@storeMovieComment');
    Route::put('/users/{nickname}/movies/{movie_id}/comments/{comment_id}', 'CommentController@update');

    Route::get('/movies', 'MovieController@index');
    Route::get('/movies/{movie}', 'MovieController@show');
    Route::post('/movies', 'MovieController@store');
    Route::put('/movies/{movie_id}', 'MovieController@update');
});

/*Route::apiResource([
    'comments' => 'CommentController',
    'movies' => 'MovieController',
    'users' => 'UserController',
    'seenlist' => 'SeenListController',
    'watchlist' => 'WatchListController',
    'usermovierating' => 'UserMovieRatingController'
]);*/
