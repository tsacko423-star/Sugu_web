<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $roles = 'admin'): Response
    {
        if (! Auth::check()) {
            return redirect()->guest(route('login'));
        }

        $allowedRoles = explode('|', $roles);

        if (in_array(Auth::user()->role, $allowedRoles, true)) {
            return $next($request);
        }

        abort(403, 'Acces refuse');
    }
}
