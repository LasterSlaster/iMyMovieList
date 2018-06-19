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
Route::post('/passwords/reset/{token?}', 'UserController@forgotpw');
Route::post('/contact', 'ContactController@sendEmail');

Route::middleware('auth.jwt')->group(function() {

    Route::get('/users', 'UserController@index');
    Route::get('/users/{nickname}', 'UserController@show');
    Route::patch('/users/{nickname}', 'UserController@update');
    Route::post('/users/{nickname}/changepw', 'UserController@changepw');
    Route::delete('/users/{nickname}', 'UserController@destroy');

    Route::get('/seenlists', 'SeenListController@index');
    Route::get('/users/{nickname}/seenlist/', 'SeenListController@showList');
    Route::get('/users/{nickname}/seenlist/movies/{movie_code}', 'SeenListController@showMovie');
    Route::post('/users/{nickname}/seenlist/movies/', 'SeenListController@store');
    //Route::put('/users/{user_id}/seenlist/movies/{movie_id}', 'SeenListController@update');
    Route::delete('/users/{nickname}/seenlist/movies/{movie_code}', 'SeenListController@destroy');

    Route::get('/watchlists', 'WatchListController@index');
    Route::get('/users/{nickname}/watchlist/', 'WatchListController@showList');
    Route::get('/users/{nickname}/watchlist/movies/{movie_code}', 'WatchListController@showMovie');
    Route::post('/users/{nickname}/watchlist/movies/', 'WatchListController@store');
    //Route::put('/users/{user_id}/watchlist/movies/{movie_id}', 'WatchListController@update');
    Route::delete('/users/{nickname}/watchlist/movies/{movie_code}', 'WatchListController@destroy');

    Route::get('/users/{nickname}/usermovieratings/movies/{movie_code}', 'UserMovieRatingController@show');
    Route::post('/users/{nickname}/usermovieratings/', 'UserMovieRatingController@store');
    Route::put('/users/{nickname}/usermovieratings/movies/{movie_code}', 'UserMovieRatingController@update');

    Route::get('/comments', 'CommentController@index');
    Route::get('/movies/{movie_code}/comments', 'CommentController@indexMovieComments');
    Route::get('/users/{nickname}/comments', 'CommentController@indexUserComments');
    Route::get('/comments/{comment}', 'CommentController@show');
    Route::post('/comments', 'CommentController@storeMovieComment');
    Route::put('/users/{nickname}/movies/{movie_code}/comments/{comment_id}', 'CommentController@update');

    Route::get('/movies', 'MovieController@index');
    Route::get('/movies/{movie_code}', 'MovieController@show');
    Route::post('/movies', 'MovieController@store');
    Route::put('/movies/{movie_code}', 'MovieController@update');
});

/*Route::apiResource([
    'comments' => 'CommentController',
    'movies' => 'MovieController',
    'users' => 'UserController',
    'seenlist' => 'SeenListController',
    'watchlist' => 'WatchListController',
    'usermovierating' => 'UserMovieRatingController'
]);*/
