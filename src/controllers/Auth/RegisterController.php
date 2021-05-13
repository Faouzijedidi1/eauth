<?php

namespace Outdare\Auth\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Where to redirect users after login.
     * Override the redirectTo property
     */
    protected function redirectTo()
    {
        return config()->get("auth::auth.redirect_path");
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    protected function userRegister(Request $request){
        $rules = ['name' => 'required','email' => 'required','password' => 'required'];
        if(config()->get('auth::auth.enable_roles')){
            $rules = ['name' => 'required','email' => 'required','password' => 'required','role'=>'required'];
        }
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json(array('error' => true,'message' => $validator->messages()), 200);
        }

        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');

        if(User::where('email',$email)->first() != null){
          return response()->json(array('error' => true,'message' => "Already exists a User with that email"), 200);
        }

        $user = new User;
        $user->name = $name;
        $user->email = $email;
        $user->password = bcrypt($password);
        $user->save();

        if(config()->get('auth::auth.enable_roles')){
            $role = $request->input('role');
            $exists = Role::where('name',$role)->first();
            if($exists == null){
                $user->delete();
                return response()->json(array('error' => true,'message' => "There is no role found with that name"), 200);
            }
            $user->roles()->attach($exists);
        }

        return response()->json(array('error' => false,'message' => "Registed successfully"), 200);
    }
}
