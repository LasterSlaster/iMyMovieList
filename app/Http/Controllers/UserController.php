<?php

namespace App\Http\Controllers;

use App\User;
use App\SeenList;
use App\WatchList;
use App\Http\Resources\UserCollection;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;

class UserController extends Controller
{

    public function signup(Request $request) {
        $nicknameTemp = $request->input('nickname');
        $request->merge(['nickname' => strtolower($request->nickname)]);

        $this->validate($request, [
            'nickname' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        $request->merge(['nickname' => $nicknameTemp]);

        $user = new User([
            'nickname' => $request->input('nickname'),
            'email' => $request->input('email'),
            'password' => bcrypt(base64_decode($request->input('password')))
        ]);
        $user->save();

        $seenList = new SeenList();
        $seenList->user_id = $user->id;
        $seenList->save();
        $watchList = new WatchList();
        $watchList->user_id = $user->id;
        $watchList->save();

        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }

    public function signin(Request $request) {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $credentials = ['email' => strtolower($request->input(email)), 'password' => base64_decode($request->input(password))];
        try {
            if(!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'error' => 'Invalid Credentials!',
                    'credentials' => $credentials
                ], 401);
            }
        } catch (JWTException $e) {
            return response()->json([
                'error' => 'Could not create token!'
            ], 500);
        }
        return response()->json([
            'token' => $token,
            'user' => json_encode(JWTAuth::toUser($token))
        ], 200);
    }

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
    public function show($nickname)
    {
        return new UserResource(User::where('nickname', $nickname)->firstOrFail());
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
    public function update(Request $request, $nickname)
    {
        $authUser = JWTAuth::parseToken()->toUser();
        if ($authUser->role != 'admin') {
            return Response::create('Not authoritzed to access this resource', 403);
        }
        $user = User::where('nickname', $nickname)->firstOrFail();
        //Validation
        if (is_null($request->role) && ($request->role != 'admin' || $request->role != 'user'))
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
    public function destroy($nickname)
    {
        $user = User::where('nickname', $nickname)->firstOrFail();
        $authUser = JWTAuth::parseToken()->toUser();
        if (!($authUser->nickname != $nickname || $authUser->role != 'admin')) {
            return Response::create('Not authorized to access this resource', 403);
        }
        //TODO: Also check for a solution to define a cascade deletion in the migration class or delete methods on model
        //Instead of deleting the user and all dependent entries try laravel soft delition
        $user->seenList()->delete();
        $user->watchList()->delete();
        $user->userMovieRatings()->delete();
        $user->comments()->delete();
        $user->delete();

        return response('Deleted user '.$nickname, 200);
    }
}
