<?php

namespace App\Http\Controllers;

use App\Comment;
use App\User;
use App\Movie;
use App\Http\Resources\CommentCollection;
use App\Http\Resources\CommentResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
        if ($comments == null)
            return Response::create('No comments available', 404);

        return new CommentCollection($comments);
    }


    /**
     * Display the specified resource.
     *
     * @param  Comment $comment
     * @return \Illuminate\Http\Response
     */
    public function indexMovieComments($movie_id)
    {
        $comments = Comment::where('movie_id', $movie_id)->paginate(20);

        if ($comments == null)
            return Response::create('No comments to movie: ' . $movie_id . ' available', 404);

        // find comment to current user an add it to the colleciton with ->merge()
        // Create collections first then paginate
        return new CommentCollection($comments);
    }

    /**
     * Display the specified resource.
     *
     * @param  Comment $comment
     * @return \Illuminate\Http\Response
     */
    public function indexUserComments($user_id)
    {
        $comments = Comment::where('user_id', $user_id)->paginate(20);

        if ($comments == null)
            return Response::create('No comments to movie: ' . $user_id . ' available', 404);

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
        if ($request->movie_id == null || $request->user_id == null)
            return Response::create('JSON must contain a movie_id and a user_id', 422);

        $relatedMovie = Movie::find($request->movie_id);
        $relatedUser = User::find($request->user_id);

        if ($relatedMovie == null || $relatedUser == null)
            return Response::create('JSON body must contain a valid user and movie id', 422);

        $comment = new Comment();
        $comment->user_id = $request->user_id;
        $comment->movie_id = $request->movie_id;
        $comment->text = $request->text;
        $comment->store();

        return (new CommentResource($comment))->response()->setStatusCode(201);
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
    public function update(Request $request, $user_id, $movie_id, $comment_id)
    {
        //Validation
        if ($request->user_id != $user_id || $request->movie_id != $movie_id)
            return Response::create('URL parameters must match request body attributes', 422);

        $comment = Comment::find($comment_id);

        if ($comment == null) {
            $comment = new Comment();
        }

        $comment->user_id = $request->user_id;
        $comment->movie_id = $request->movie_id;
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
