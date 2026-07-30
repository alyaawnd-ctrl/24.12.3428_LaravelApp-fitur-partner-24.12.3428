<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && in_array(Auth::user()->role, ['superadmin', 'organizer'])) {
            return $next($request);
        }

        if (Auth::check()) {
            abort(403, 'Akses Ditolak: Halaman ini hanya diperuntukkan bagi Admin Penyelenggara.');
        }

        return redirect()->route('admin.login');
    }
}
