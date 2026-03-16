<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class KasirRole
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek dari guard 'admin'
        if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->role === 'kasir') {
            return $next($request);
        }

        // Cek dari guard 'web'
        if (Auth::guard('web')->check() && Auth::guard('web')->user()->role === 'kasir') {
            return $next($request);
        }

        abort(403, 'Akses ditolak. Hanya kasir yang dapat mengakses halaman ini.');
    }
}
