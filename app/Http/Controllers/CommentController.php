<?php

namespace App\Http\Controllers;

use App\Comment;
use App\User;
use App\Movie;
use App\Http\Resources\CommentCollection;
use App\Http\Resources\CommentResource;
use Illuminate\Http\Request;

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
        Movie::findOrFail($request->movie_id);
        User::findOrFail($request->user_id);

        $comment = new Comment();
        $comment->user_id = $request->user_id;
        $comment->movie_id = $request->movie_id;
        $comment->text = $request->text;
        $comment->store();

        return new CommentResource($comment);
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
        //TODO: Check result for not existing comments
        $comment = Comment::find($comment_id);

        if ($comment == null) {
            $comment = new Comment();
        }

        $comment->user_id = $request->user_id;
        $comment->movie_id = $request->movie_id;
        $comment->comment_text = $request->comment_text;
        $comment->save();

        return new CommentController($comment);
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
