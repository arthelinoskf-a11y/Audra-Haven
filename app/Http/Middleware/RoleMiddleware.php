<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Jika user belum login atau role-nya tidak ada di daftar
        if (!Auth::check() || !in_array(Auth::user()->role->name, $roles)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}