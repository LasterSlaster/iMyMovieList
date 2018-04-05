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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/users/{user_id}/usermovieratings/{movie_id}', 'UserMovieRatingsController@show');
Route::post('/users/usermovieratings/', 'UserMovieRatingController@store');
Route::put('/users/{user_id}/usermovieratings/{movie_id}', 'UserMovieRatingController@update');

Route::get('/users/{user_id}/seenlist/', 'SeenListController@show');
Route::put('/users/{user_id}/seenlist/movie/{movie_id}', 'SeenListController@update');
Route::delete('/users/{user_id}/seenlist/movie({movie_id}', 'SeenListController@delete');

Route::get('/users', 'UserController@index');
Route::delete('/users/{user}', 'UserController@destroy');

Route::get('/movies/{movie_id}/comments/', 'CommentController@show');
Route::post('/movies/{movie_id}/comments/', 'CommentController@store');


/*Route::apiResource([
    'comments' => 'CommentController',
    'movies' => 'MovieController',
    'users' => 'UserController',
    'seenlist' => 'SeenListController',
    'watchlist' => 'WatchListController',
    'usermovierating' => 'UserMovieRatingController'
]);*/
