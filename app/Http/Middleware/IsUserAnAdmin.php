<?php

namespace App\Http\Middleware;

use Closure;

class IsUserAnAdmin
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
        if(auth()->user()->role_id_foreign !== 1){
            abort(403);
        }
        return $next($request);
    }
}
