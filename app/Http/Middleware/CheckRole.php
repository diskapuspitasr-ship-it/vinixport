<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('guest.login.index');
        }

        // 2. Cek apakah role user sesuai dengan yang diminta
        // $role adalah parameter yang dikirim dari route (misal: 'admin' atau 'user')
        if (Auth::user()->role !== $role) {

            // Jika role tidak cocok, lempar error 403 (Forbidden)
            // Atau bisa redirect ke halaman lain
            abort(403, 'Akses ditolak. Anda bukan ' . ucfirst($role));
        }

        return $next($request);
    }
}
