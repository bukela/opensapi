<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class DonatorOnly
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
        if($request->user() && !$request->user()->isDonator()){

            return response()->json('You Don\'t Have Access Permissions');
            
        }
        return $next($request);
    }

}
