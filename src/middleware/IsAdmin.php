<?php

namespace Outdare\Auth\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $valid = false;
        $user = Auth::user();

        if($user != null && $user){
            $valid = $user->hasRole("admin");
        }

        if($valid == false){
            if ($request->ajax()){
                return response()->json(array('error' => true, 'message' => 'Unauthorized action'),403);
            } else{
                Auth::logout();
                return response()->view('auth.login', array('forbidden'=>'Unauthorized action'), 403);
            }
        }

        return $next($request);
    }
}
