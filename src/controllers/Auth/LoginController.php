<?php

namespace Outdare\Auth\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

use Auth;
use Cookie;

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
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Where to redirect users after login.
     * Override the redirectTo property
     */
    protected function redirectTo()
    {
        return config()->get("auth::auth.redirect_path");
    }

    /*
    * Login through post request
    */
    public function userLogin()
    {
        $inputs = array(
            'email' => request()->email,
            'password' => request()->password,
        );

        if(Auth::attempt($inputs)){
            return response()->json(['error' => false]);
        }else{
            return response()->json(['error' => true]);
        }
    }
}
