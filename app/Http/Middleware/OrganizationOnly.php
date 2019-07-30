<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class OrganizationOnly
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
        if($request->user() && !$request->user()->isOrganization()){

            return response()->json('You Don\'t Have Access Permissions');
            
        }
        return $next($request);    
    }
}
