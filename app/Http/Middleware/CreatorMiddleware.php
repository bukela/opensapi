<?php

namespace App\Http\Middleware;

use Closure;

class CreatorMiddleware
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
        $roles = [2,3];
        
        if(in_array(auth('api')->user()->role_id, $roles)) {
            
            return $next($request);
            
        }
        return response()->json('You Don\'t Have Access Permissions');
    }
}
