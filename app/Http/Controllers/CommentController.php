<?php

namespace App\Http\Controllers;

use App\Comment;
use App\User;
use App\Movie;
use App\Http\Resources\CommentCollection;
use App\Http\Resources\CommentResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JWTAuth;

/**
 * Class CommentController
 * @package App\Http\Controllers
 */
class CommentController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::paginate(20);
        //TODO: Check if null value is possible for paginate
        if (is_null($comments))
            return Response::create('No comments available', 404);

        return new CommentCollection($comments);
    }


    /**
     * Display the specified resource.
     *
     * @param  Comment $comment
     * @return \Illuminate\Http\Response
     */
    public function indexMovieComments($movie_code)
    {
        $movie = Movie::where('movie_code', $movie_code)->firstOrFail();
        $comments = Comment::where('movie_id', $movie->id)->paginate(20);

        if (is_null($comments))
            return Response::create('No comments to movie: ' . $movie_code . ' available', 404);

        //find current user comment
        $userComment = Comment::where('user_id', JWTAuth::parseToken()->toUser()->id)->where('movie_id', $movie->id)->first();
        //TODO: Check behavior on not existing comment!!!
        // Create collections first then paginate
        return (new CommentCollection($comments))
            ->additional([
                'user' => json_encode($userComment)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  Comment $comment
     * @return \Illuminate\Http\Response
     */
    public function indexUserComments($nickname)
    {
        //Validation
        $authUser = JWTAuth::parseToken()->toUser();

        if ($authUser->nickname != $nickname)
            return Response::create('Not authorized to access this resource', 403);

        $user = User::where('nickname', $nickname)->firstOrFail();
        $comments = Comment::where('user_id', $user->id)->paginate(20);

        if (is_null($comments))
            return Response::create('No comments to movie: ' . $nickname . ' available', 404);

        return new CommentCollection($comments);
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
        if (is_null($request->movie_code) || is_null($request->nickname))
            return Response::create('JSON must contain a movie_code and a nickname', 422);

        $authUser = JWTAuth::parseToken()->toUser();

        if ($authUser->nickname != $request->nickname)
            return Response::create('Not authorized to access this resource', 403);

        $relatedMovie = Movie::where('movie_code', $request->movie_code)->first();
        $relatedUser = User::where('nickname', $request->nickname)->first();

        if (is_null($relatedMovie)|| is_null($relatedUser))
            return Response::create('JSON body must contain a valid user and movie id', 422);

        $comment = new Comment();
        $comment->user_id = $relatedUser->id;
        $comment->movie_id = $relatedMovie->id;
        $comment->text = $request->text;
        $comment->store();

        return (new CommentResource($comment))->response()->setStatusCode(201)->header('location', url()->full()."/".$comment->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  Comment $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        return new CommentResource($comment);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  Comment $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Comment $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $nickname, $movie_code, $comment_id)
    {
        //Validation
        if ($request->nickname != $nickname || $request->movie_code != $movie_code)
            return Response::create('URL parameters must match request body attributes', 422);

        $comment = Comment::find($comment_id);

        if (is_null($comment)) {
            $comment = new Comment();
        }

        $user = User::where('nickname', $nickname)->first();
        if (is_null($user))
            return Response::create('No such user', 404);

        $movie = Movie::where('movie_code', $movie_code)->firstOrFail();

        $comment->user_id = $user->id;
        $comment->movie_id = $movie->id;
        $comment->comment_text = $request->comment_text;
        $comment->save();

        return (new CommentResource($comment))->response()->setStatusCode(201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Comment $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
