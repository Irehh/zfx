<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class User
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    public function handle($request, Closure $next)
    {
        if($request->user()->role=='user'){
            return $next($request);
        }
        else{
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        if(empty(session('user'))){
            return response()->json(['error' => 'Sign Up'], 401);
        }
        else{
            return $next($request);
        }
    }
}
