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
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword;

/**
 * Class UserController - Controller for requests to user resources
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    use Notifiable;
    use CanResetPassword;
    /**
     * Register a new user and store it in storage
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function signup(Request $request) {
        $nicknameTemp = $request->input('nickname');
        // Convert nickname to lower case to reject differently cased names
        $request->merge(['nickname' => strtolower($request->input('nickname'))]);

        $this->validate($request, [
            'nickname' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        // Add original cased nickname
        $request->merge(['nickname' => $nicknameTemp]);

        $user = new User([
            'nickname' => $request->input('nickname'),
            'email' => $request->input('email'),
            // Decode the encoded password from the request and encrypt it again to store it
            'password' => bcrypt(base64_decode($request->input('password')))
        ]);
        $user->save();

        //Create movie lists for new user
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

    /**
     * Login an existing user and receive an authorization token
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function signin(Request $request) {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        // decode password
        $credentials = ['email' => strtolower($request->input('email')), 'password' => base64_decode($request->input('password'))];
        try {
            if(!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'error' => 'Invalid Credentials!'
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
     * Reset current password.
     *
     * @return \Illuminate\Http\Response
     */
    public function forgotpw()
    {

    }

    /**
     * Change the current password to a new one.
     *
     * @return \Illuminate\Http\Response
     * @param  string $nickname
     * @return \Illuminate\Http\Response
     */
    public function changepw(Request $request, $nickname)
    {
        $authUser = JWTAuth::parseToken()->toUser();
        if ($authUser->nickname != $nickname) {
            return Response::create('Not authorized to access this resource', 403);
        }
        if ($request->password_old == '' || $request->password_new == ''|| $request->password_confirmation == '') {
            return Response::create('Request must contain a nickname, password and password_confirmation');
        }
        if (strcmp($request->password_new, $request->password_confirmation)) {
            return Response::create('Old and new password must be equal', 400);
        }

        $authUser->password = bcrypt(base64_decode($request->password_new));
        $authUser->save();

        return response('Change password successful', 200);

    }


    /**
     * Display a listing of the user resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->search != null) {
            return new UserCollection(User::where('nickname', 'like', '%'.$request->search.'%')->orderBy('nickname', 'desc')->paginate(20));
        } else {
            return new UserCollection(User::paginate(20));
        }
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
     * Return the specified user resource.
     *
     * @param  string $nickname
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
     * Update the specified user resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $nickname
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $nickname)
    {
        $authUser = JWTAuth::parseToken()->toUser();
        if ($authUser->role != 'admin') {
            return Response::create('Not authorized to access this resource', 403);
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
     * Remove the specified user resource from storage.
     *
     * @param  string $nickname
     * @return \Illuminate\Http\Response
     */
    public function destroy($nickname)
    {
        $user = User::where('nickname', $nickname)->firstOrFail();
        $authUser = JWTAuth::parseToken()->toUser();

        //TODO: Also check for a solution to define a cascade deletion in the migration class or delete methods on model
        //Instead of deleting the user and all dependent entries try laravel soft delition
        if ($authUser->nickname != $nickname && $authUser->role == 'admin') {
            $user->seenList()->delete();
            $user->watchList()->delete();
            $user->userMovieRatings()->delete();
            $user->comments()->dfelete();
            $user->delete();
            return new UserCollection(User::paginate(20));
        }

        return Response::create('Not authorized to access this resource', 403);
    }
}
