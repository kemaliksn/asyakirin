<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        // Jika sudah login sebagai admin (tabel admins)
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        // Jika sudah login sebagai pengurus (tabel users)
        if (Auth::guard('web')->check() && in_array(Auth::guard('web')->user()->role, ['admin', 'pengurus'])) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // ── Coba 1: login sebagai admin (tabel admins) ──
        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        // ── Coba 2: login sebagai pengurus (tabel users) ──
        if (Auth::guard('web')->attempt($credentials)) {
            $user = Auth::guard('web')->user();

            // Hanya izinkan role admin atau pengurus
            if (in_array($user->role, ['admin', 'pengurus'])) {
                $request->session()->regenerate();
                return redirect()->route('admin.dashboard');
            }

            // Role tidak sesuai (donatur biasa) → tolak & logout
            Auth::guard('web')->logout();
        }

        return back()->withErrors([
            'email' => 'Email atau password salah, atau akun tidak memiliki akses dashboard.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
