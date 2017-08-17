<?php

namespace Amcor\Http\Middleware;

use Closure;

class ClientMiddleware
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
        if($request->user()->accounttype != 10) {
            return redirect('/');
        }

        return $next($request);
    }
}
