<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuth
{
    public function handle(Request $request, Closure $next)
    {
        // Cek guard 'admin' (tabel admins)
        if (Auth::guard('admin')->check()) {
            return $next($request);
        }

        // Cek guard 'web' (tabel users) dengan role admin/pengurus
        if (Auth::guard('web')->check()) {
            $role = Auth::guard('web')->user()->role;
            if (in_array($role, ['admin', 'pengurus'])) {
                return $next($request);
            }
        }

        return redirect()->route('admin.login');
    }
}
