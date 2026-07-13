<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        // Secara default, cek guard 'web' (atau guard lain jika ada yang dispesifikasikan)
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Jika pengguna sudah login, alihkan ke dashboard
                return redirect()->route('admin.dashboard');
            }
        }

        // Jika pengguna belum login, lanjutkan request
        return $next($request);
    }
}
