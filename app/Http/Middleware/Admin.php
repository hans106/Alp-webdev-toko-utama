<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login dan memiliki role admin
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'superadmin'])) {
            // Jika bukan admin atau superadmin, redirect ke home
            return redirect('/')->with('error', 'Akses ditolak! Hanya admin yang bisa mengakses area ini.');
        }

        return $next($request);
    }
}
