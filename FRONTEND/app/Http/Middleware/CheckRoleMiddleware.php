<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRoleMiddleware
{
  /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Periksa apakah pengguna sudah login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Periksa peran pengguna
        $user = Auth::user();
        foreach ($roles as $role) {
            if ($user->role_id == $role) {
                return $next($request);
            }
        }

        // Jika pengguna tidak memiliki peran yang sesuai, kembalikan ke halaman sebelumnya atau halaman akses ditolak
        return redirect('/');
    }
}
