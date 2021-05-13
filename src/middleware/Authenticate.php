<?php

namespace Outdare\Auth\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {

        if (Auth::guest())
        {
            if ($request->ajax())
            {
                return response('Unauthorized.', 401);
            } else
            {
                return redirect()->guest(config()->get("auth::auth.redirect_path"));
            }
        }

        return $next($request);
    }
}
