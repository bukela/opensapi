<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
class AdminOnly
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
        if($request->user() && !$request->user()->isAdmin()){
            return abort(403);
            // abort(Response::HTTP_FORBIDDEN);
        }
        return $next($request);
    }
}
