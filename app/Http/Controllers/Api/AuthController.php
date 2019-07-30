<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\User;

class AuthController extends Controller
{
    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    // public function signup(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string',
    //         'email' => 'required|string|email|unique:users',
    //         'password' => 'required|string|confirmed'
    //     ]);

    //     $user = new User([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => bcrypt($request->password)
    //     ]);

    //     $user->save();

    //     return response()->json([
    //         'message' => 'Successfully created user!'
    //     ], 201);
    // }
  
    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        $credentials = request(['email', 'password']);
        $credentials = array_add($credentials, 'active', 1);
        // $credentials = array_add($credentials, 'role_id', 2);
        // $credentials = array_add($credentials, 'role_id', 3);

        if(!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Check Credentials And Try Again'
            ], 401);

        $user = $request->user();

        if($user->role_id == 1)
            return response()->json([
                'message' => 'Admin Not Allowed',
                'admin_dashboard' => 'http://opens-api.dev.extraordinary.rs'
            ], 401);

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(3);

        $token->save();

        if(count($user->donators) || $user->role_id == 2) {
            return response()->json([
                'access_token' => $tokenResult->accessToken,
                'moderator' => $user->moderator == 1 ? true : false,
                'donator' => true,
                'email' => $user->email
            ]);
        }

        if(count($user->organizations) || $user->role_id == 3) {
            return response()->json([
                'access_token' => $tokenResult->accessToken,
                'moderator' => $user->moderator == 1 ? true : false,
                'organization' => true,
                'email' => $user->email
            ]);
        }

        if($user->role->code == 'admin') {
            return response()->json([
                'access_token' => $tokenResult->accessToken,
                'super_admin' => true,
                'email' => $user->email
            ]);
        }
        // return response()->json([
        //     'access_token' => $tokenResult->accessToken,
        //     'role_id' => $user->role_id,
        //     'moderator' => $user->moderator == 1 ? true : false,
        //     'donator' => count($user->donators) ? true : false,
        //     'organization' => count($user->organizations) ? true : false,
        //     'token_type' => 'Bearer',
        //     'expires_at' => Carbon::parse(
        //         $tokenResult->token->expires_at
        //     )->toDateTimeString()
        // ]);
    }
  
    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
  
    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
    
}
