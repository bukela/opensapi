<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    
    public function redirectTo(){
        if (auth()->user()->isAdmin()) {
            return '/admin';
        }else if (auth()->user()->is('donator')){
            return '/donator';
        }else if (auth()->user()->is('organization')){
            return '/organization';
        }
        else {
            return $this->redirectTo;
        }
    }

    protected function credentials(\Illuminate\Http\Request $request)
        {
            $credentials = $request->only($this->username(), 'password');

            return array_add($credentials, 'active', '1');
        }
   
}
