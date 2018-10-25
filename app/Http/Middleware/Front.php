<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Redirect;

class Front
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
        if (Auth::guard('front')->check() && Auth::guard('front')->user()->isUser() && sizeof(Auth::guard('front')->user()->company()->get())) {
                return $next($request);
        } else {
            Auth::guard('front')->logout();
            return Redirect::to(route('login'))->withErrors('You are not authorised user!');
        }

        return $next($request);
    }
}
