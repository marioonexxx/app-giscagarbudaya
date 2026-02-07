<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CekPeran
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$perans  // Tambahkan parameter ini untuk menangkap 'super_admin'
     */
    public function handle(Request $request, Closure $next, ...$perans): Response
    {
        // 1. Cek apakah user sudah login
        if (!auth()->check()) {
            return redirect('login');
        }

        // 2. Cek apakah peran user saat ini ada di dalam daftar $perans yang dikirim dari route
        if (in_array(auth()->user()->peran, $perans)) {
            return $next($request);
        }

        // 3. Jika tidak punya akses, lempar ke 403 Forbidden
        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }
}
