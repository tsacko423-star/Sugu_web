<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
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
       if (!auth()->check()) {
    return redirect('/login');
}

$allowedRoles = ['admin', 'editor']; // tableau de rôles autorisés

if (!\in_array(auth()->user()->role, $allowedRoles)) {
    abort(403, 'Accès refusé');
       }
   return $next($request);
}
  
}