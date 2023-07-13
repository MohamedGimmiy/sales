<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {

            if(Auth::guard($guard)->check()){
                // write code for admin or front in case login
                if($request->is('admin' || $request->is('admin/*'))){
                    // redirect backend
                    return redirect(RouteServiceProvider::Admin);
                } else {
                    // redirect front end
                    return redirect(RouteServiceProvider::Admin);

                    //return redirect(RouteServiceProvider::HOME);

                }
            }
        }

        return $next($request);
    }
}
