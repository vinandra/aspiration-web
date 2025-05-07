<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect('/login')->withErrors([
                'nik' => 'Anda harus login terlebih dahulu.',
            ]);
        }

        $user = Auth::user();
        $userRole = optional($user->role)->name;

        // Cek apakah user memiliki role
        if (!$userRole) {
            // Logout user jika tidak ada role
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/login')->withErrors([
                'nik' => 'Role pengguna tidak dikenali. Silakan hubungi admin.',
            ]);
        }

        // Cek apakah role user termasuk dalam role yang diperbolehkan
        if (!in_array($userRole, $roles)) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
