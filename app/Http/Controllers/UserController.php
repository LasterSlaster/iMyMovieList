<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Resources\UserCollection;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new UserCollection(User::paginate(20));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user_id)
    {
        $user = User::findOrFail($user_id);
        //Validation
        if ($request->role == null && ($request->role != 'admin' || $request->role != 'user'))
            return Response::create('JSON body must contain attribute role. Possible values: admin|user', 422);

        $user->role = $request->role;
        $user->save();

        return (new UserResource($user))->response()->setStatusCode(201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //TODO: Also check for a solution to define a cascade deletion in the migration class or delete methods on model
        //Instead of deleting the user and all dependent entries try laravel soft delition
        $user->seenList()->delete();
        $user->watchList()->delete();
        $user->userMovieRatings()->delete();
        $user->comments()->delete();
        $user->delete();

        return (new UserResource($user))->response()->setStatusCode(200);
    }
}
