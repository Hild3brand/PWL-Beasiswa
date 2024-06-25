<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    //  method untuk memeriksa hak akses dari seorang Super Admin
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $request->user()->role_id === 1) {
            return $next($request);
        }

        return redirect('/');
    }
}
