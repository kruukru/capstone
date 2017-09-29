<?php

namespace Amcor\Http\Middleware;

use Closure;

class HRMiddleware
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
        if ($request->user()->accounttype == 0 || $request->user()->accounttype == 3) {
            return $next($request);
        }

        return redirect('/');
    }
}
