<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAuthentication {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if(!Auth::check()) {//if user is not authenticated
            return redirect('/')->with('update_error', "Unautherized access. Login to continue");
        }
        return $next($request);
    }
}
