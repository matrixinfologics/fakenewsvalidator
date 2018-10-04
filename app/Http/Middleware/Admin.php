<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Redirect;

class Admin
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
        if (Auth::check() && (Auth::user()->isAdmin() || Auth::user()->isCompanyAdmin())) {
            if (Auth::user()->isAdmin()) {
                return $next($request);
            } elseif (Auth::user()->isCompanyAdmin() &&
                $request->is('admin/users/*', 'admin', 'admin/users', 'admin/companies/*') &&
                Auth::user()->hasPermissionToAction($request)) {

                return $next($request);
            } else {
                return Redirect::to(route('dashboard'))->with('error', 'You have not permissions for this action.');
            }
        } else {
            Auth::logout();
            return Redirect::to(route('admin.login'));
        }

        return $next($request);
    }
}
