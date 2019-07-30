<?php

namespace App\Http\Middleware;

use Closure;

class ModeratorOnly
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
        if($request->user('api') && !$request->user('api')->moderator == 1){

            return response()->json('You Don\'t Have Access Permissions');
            
        }
        return $next($request);  
    }
}
