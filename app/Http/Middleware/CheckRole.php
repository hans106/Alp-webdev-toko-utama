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
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('/')->with('error', 'Akses ditolak! Silakan login.');
        }

        $userRole = strtolower(trim(Auth::user()->role ?? ''));

        // Collect allowed roles from either a single comma-separated string or multiple params
        $allowed = [];
        foreach ($roles as $r) {
            if (is_string($r) && $r !== '') {
                $parts = array_map('trim', explode(',', $r));
                foreach ($parts as $p) {
                    if ($p !== '') {
                        $allowed[] = strtolower($p);
                    }
                }
            }
        }

        // If no roles specified, deny access
        if (empty($allowed)) {
            return response()->view('errors.unauthorized', ['allowedRoles' => []], 403);
        }

        // Check membership
        if (!in_array($userRole, $allowed)) {
            return response()->view('errors.unauthorized', ['allowedRoles' => $allowed], 403);
        }

        return $next($request);
    }
}
