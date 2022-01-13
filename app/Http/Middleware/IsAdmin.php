<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

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
        error_log(auth()->user());
        if(auth()->user()->user_role == "admin"){
            return $next($request);
        }
   
        return response()->json(['status' => "You don't have of this route"]);
    }
}
