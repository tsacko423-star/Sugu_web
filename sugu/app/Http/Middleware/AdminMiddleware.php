<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
      public function handle($request, Closure $next)
     {
       if (Auth::user() && Auth::user()->role === 'admin') {
        return $next($request);
       }

      abort(403, 'Accès refusé');
     }
}
