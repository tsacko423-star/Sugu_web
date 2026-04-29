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
   public function handle(Request $request, Closure $next, $role): Response
{
    if (!Auth::check()) {
        return redirect('/login');
    }

    $userRole = Auth::user()->role;

    // $role peut être "admin" ou "admin|editor"
    $roles = explode('|', $role);

    if (!in_array($userRole, $roles)) {
        abort(403, 'Accès refusé');
    }

    return $next($request);
}
  
}