<?php

namespace App\Http\Middleware;

use Closure;

class KeyMiddleware
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
			if ($request->session()->exists('key')) {
				return $next($request);
			}

			return redirect('/');
    }
}
