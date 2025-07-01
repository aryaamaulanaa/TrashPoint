<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Tambahkan ini
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login dan role-nya adalah 'admin'
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request); // Lanjutkan request jika role-nya admin
        }

        // Jika bukan admin atau belum login, redirect ke halaman dashboard user biasa
        // Atau ke halaman login dengan pesan error
        return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses sebagai Admin.');
        // Atau bisa juga redirect ke halaman login:
        // return redirect('/login')->with('error', 'Anda tidak memiliki akses.');
    }
}