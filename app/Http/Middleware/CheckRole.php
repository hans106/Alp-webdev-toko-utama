<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     * Usage in routes: ->middleware('role:superadmin,inventory')
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $roles = null): Response
    {
        if (!Auth::check()) {
            return redirect('/')->with('error', 'Akses ditolak! Silakan login.');
        }

        $userRole = Auth::user()->role;

        if (is_null($roles) || $roles === '') {
            // no roles specified => deny
            return redirect('/')->with('error', 'Akses ditolak!');
        }

        $allowed = array_map('trim', explode(',', $roles));

        if (!in_array($userRole, $allowed)) {
            return redirect('/')->with('error', 'Akses ditolak! Anda tidak memiliki izin.');
        }

        return $next($request);
    }
}
