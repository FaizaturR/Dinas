<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminRole
{
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        $allowedRoles = explode(',', $roles);

        if (! auth()->check()) {
            abort(403, 'Akses ditolak.');
        }

        $userRole = auth()->user()->role;

        // Superadmin otomatis boleh mengakses semua halaman yang bisa diakses admin biasa.
        if ($userRole === 'superadmin') {
            return $next($request);
        }

        if (! in_array($userRole, $allowedRoles, true)) {
            abort(403, 'Akses ditolak.');
        }

        return $next($request);
    }
}