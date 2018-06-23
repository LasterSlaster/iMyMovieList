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
use Illuminate\Support\Facades\Hash;

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

        $this->validate($request, [
            'nickname' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:4'
        ]);

        // Convert nickname to lower case to reject differently cased names
        $nicknameTemp = $request->input('nickname');
        $request->merge(['nickname' => strtolower($request->input('nickname'))]);

        // Add original cased nickname
        $request->merge(['nickname' => $nicknameTemp]);

        $user = new User([
            'nickname' => $request->input('nickname'),
            'email' => $request->input('email'),
            'password' => Hash::make(base64_decode($request->input('password')))
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
            'password' => 'required|min:4'
        ]);

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
     * Logout an existing user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request) {
        $this->validate($request, ['token' => 'required']);

        try {
            JWTAuth::invalidate($request->input('token'));
            return response()->json(['success' => true, 'message'=> "You have successfully logged out."]);
        } catch (JWTException $e) {
            return response()->json(['success' => false, 'error' => 'Failed to logout, please try again.'], 500);
        }
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
        $this->validate($request, [
            'password_confirmation' => 'required|min:4',
            'password_old' => 'required|min:4',
            'password_new' => 'required|min:4'
            ], ['Request must contain a nickname, password and password_confirmation']);

        $authUser = JWTAuth::parseToken()->toUser();
        if ($authUser->nickname != $nickname) {
            return Response::create('Not authorized to access this resource', 403);
        }
        if (strcmp($request->password_new, $request->password_confirmation)) {
            return Response::create('Old and new password must be equal', 403);
        }
        if (!(Hash::check(base64_decode($request->get('password_old')), $authUser->password))) {
            return Response::create('Wrong password', 403);
        }
        $authUser->password = Hash::make(base64_decode($request->password_new));
        $authUser->save();

        return response()->json([
            'message' => 'Successfully changed password!'
        ], 200);
    }


    /**
     * Display a listing of the user resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->search != null) {
            //Return users match the search string
            return new UserCollection(User::where('nickname', 'like', '%'.$request->search.'%')->orderBy('nickname', 'desc')->paginate(20));
        } else {
            //Return all users in db
            return new UserCollection(User::paginate(20));
        }
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
     * Update the specified user resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $nickname
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $nickname)
    {
        $this->validate($request, [
            'role' => 'required|in:admin,user'
        ], ['Role must be either admin or user!']);

        $authUser = JWTAuth::parseToken()->toUser();
        if ($authUser->role != 'admin') {
            return Response::create('Not authorized to access this resource', 403);
        }
        $user = User::where('nickname', $nickname)->firstOrFail();

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

        if ($authUser->nickname != $nickname && $authUser->role == 'admin') {
            $user->seenList()->delete();
            $user->watchList()->delete();
            $user->userMovieRatings()->delete();
            $user->comments()->delete();
            $user->delete();
            return new UserCollection(User::paginate(20));
        }

        return Response::create('Not authorized to access this resource', 403);
    }
}
