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
 * Class CommentController - Controller for requests to comment resources
 * @package App\Http\Controllers
 */
class CommentController extends Controller
{

    /**
     * Return a paginated listing of the comment resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::paginate(20);

        if ($comments->isEmpty())
            return Response::create('No comments available', 404);

        return new CommentCollection($comments);
    }


    /**
     * Return a paginated listing of the comment resource for a certain movie.
     *
     * @param  string $movie_code
     * @return \Illuminate\Http\Response
     */
    public function indexMovieComments($movie_code)
    {
        $movie = Movie::where('movie_code', $movie_code)->firstOrFail();
        $comments = Comment::where('movie_id', $movie->id)->paginate(20);

        if ($comments->isEmpty())
            return Response::create('No comments to movie: ' . $movie_code . ' available', 404);

        //find current user comment
        $userComment = Comment::where('user_id', JWTAuth::parseToken()->toUser()->id)->where('movie_id', $movie->id)->firstOrFail();

        // Create collections first then paginate
        return (new CommentCollection($comments))
            ->additional([
                'user' => json_encode($userComment)
        ]);
    }

    /**
     * Return a paginated listing of the comment resource for a certain user.
     *
     * @param  string $nickname
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

        if ($comments->isEmpty())
            return Response::create('No comments to movie: ' . $nickname . ' available', 404);

        return new CommentCollection($comments);
    }


    /**
     * Store a newly created comment resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validation
        $this->validate($request, [
            'movie_code' => 'required',
            'nickname' => 'required'
        ]);

        $authUser = JWTAuth::parseToken()->toUser();

        if ($authUser->nickname != $request->nickname)
            return Response::create('Not authorized to access this resource', 403);

        $relatedMovie = Movie::where('movie_code', $request->movie_code)->firstOrFail();
        $relatedUser = User::where('nickname', $request->nickname)->firstOrFail();

        $comment = new Comment();
        $comment->user_id = $relatedUser->id;
        $comment->movie_id = $relatedMovie->id;
        $comment->text = $request->text;
        $comment->store();

        return (new CommentResource($comment))->response()->setStatusCode(201)->header('location', url()->full()."/".$comment->id);
    }

    /**
     * Return the specified comment resource.
     *
     * @param  Comment $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        return new CommentResource($comment);
    }

    /**
     * Update the specified comment resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $nickname
     * @param  string $movie_code
     * @param  int $comment_id
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
}
