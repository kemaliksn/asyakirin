<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request; // ← tambahkan ini
use App\Http\Controllers\ZakatController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\RekapController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminZakatController;
use Illuminate\Support\Facades\Auth;

// ══════════════════════════════════════════════
//  PUBLIK — Form Zakat (tidak perlu login)
// ══════════════════════════════════════════════

// Login
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::guard('web')->attempt($credentials)) {
        $request->session()->regenerate();
        return redirect('/'); // ← redirect ke form zakat
    }

    return back()->withErrors(['email' => 'Email atau password salah.']);
})->name('login.submit');

// Logout PUBLIK (donatur)
Route::post('/logout', function (Request $request) {
    Auth::guard('web')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

Route::get('/', function () {
    return view('zakat');
});

Route::post('/zakat/export-pdf', [ZakatController::class, 'exportPdf'])->name('export.pdf');
Route::get('/zakat/{id}/cetak', [ZakatController::class, 'cetakUlang'])->name('zakat.cetak-ulang');


// ══════════════════════════════════════════════
//  ADMIN — Login (tidak perlu middleware)
// ══════════════════════════════════════════════

Route::prefix('admin')->name('admin.')->group(function () {

    // Halaman login
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');

    // ── Protected routes (harus login) ──
    Route::middleware('admin.auth')->group(function () {

        // Dashboard
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Transaksi
        Route::get('/transaksi', function () {
            return view('admin.transaksi');
        })->name('transaksi');

        Route::get('/transaksi/{id}', function ($id) {
            return view('admin.transaksi-detail', ['id' => $id]);
        })->name('transaksi.show');

        // Laporan
        Route::get('/laporan', function () {
            return view('admin.laporan');
        })->name('laporan');

        // Rekap
        Route::get('/rekap', [RekapController::class, 'index'])->name('rekap');

        // Settings
        Route::get('/settings', function () {
            return view('admin.settings');
        })->name('settings');

        // Akun
        Route::get('/akun', function () {
            return view('admin.akun');
        })->name('akun');

        Route::get('/zakat/create', [AdminZakatController::class, 'create'])->name('zakat.create');
        Route::post('/zakat', [AdminZakatController::class, 'store'])->name('zakat.store');

        // ✅ Kelola Akun
        Route::resource('users', UserController::class);
        Route::patch('users/{user}/toggle', [UserController::class, 'toggleActive'])->name('users.toggleActive');

        // ✅ Kelola Akun - HANYA ADMIN
        Route::middleware('admin.only')->group(function () {
        Route::resource('users', UserController::class);
        Route::patch('users/{user}/toggle', [UserController::class, 'toggleActive'])->name('users.toggleActive');
        });

        // Logout
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    });

});
