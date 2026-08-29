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
     * Allow only authenticated users whose role is in the allowed list.
     * Usage: ->middleware('role:admin') or ->middleware('role:seller,admin')
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        // Not authenticated -> send to login
        if (! $user) {
            return redirect()->route('login');
        }

        // No role restriction given -> allow any authenticated user
        if (empty($roles)) {
            return $next($request);
        }

        // Role not allowed -> abort 403 (or redirect to own dashboard)
        if (! in_array($user->role, $roles, true)) {
            abort(403, 'Akses ditolak: anda tidak memiliki hak akses ke halaman ini.');
        }

        return $next($request);
    }
}
