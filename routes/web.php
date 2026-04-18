<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request; // ← tambahkan ini
use App\Http\Controllers\ZakatController;
use App\Http\Controllers\QurbanController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\RekapController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminZakatController;
use App\Http\Controllers\TransaksiController;
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
    $credentials['role'] = 'kasir'; // hanya role pengurus

    if (Auth::guard('admin')->attempt($credentials)) {
        $request->session()->regenerate();
        return redirect('/');
    }

    if (Auth::guard('web')->attempt($credentials)) {
        $request->session()->regenerate();
        return redirect('/');
    }

    return back()->withErrors([
        'email' => 'Akses hanya untuk pengurus atau data login salah.'
    ]);
})->name('login.submit');

// Logout PUBLIK (donatur)
Route::post('/logout', function (Request $request) {

    if (Auth::guard('admin')->check()) {
        Auth::guard('admin')->logout();
    }

    if (Auth::guard('web')->check()) {
        Auth::guard('web')->logout();
    }

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
})->name('logout');

// Form Zakat (publik + kasir + admin)
Route::get('/', function () {
    return view('zakat');
});

// Export PDF dan cetak (hanya kasir dan admin, dari form publik atau admin)
Route::post('/zakat/export-pdf', [ZakatController::class, 'exportPdf'])->name('export.pdf');
// Cetak ulang internal (admin & kasir): butuh login
Route::middleware('admin.auth')->get('/zakat/{id}/cetak', [ZakatController::class, 'cetakUlang'])->name('zakat.cetak-ulang');
// Cetak publik (donatur via WA): tanpa login
Route::get('/zakat/{id}/invoice', [ZakatController::class, 'publicInvoice'])->name('zakat.public-invoice');
// Cetak ulang invoice - admin dan kasir boleh akses (dijaga oleh AdminAuth yang membolehkan kasir/pengurus)
Route::middleware('admin.auth')->get('/zakat/{id}/cetak', [ZakatController::class, 'cetakUlang'])->name('zakat.cetak-ulang');
// Halaman invoice-ready (hanya untuk yang login)
Route::middleware('admin.auth')->group(function () {
    Route::get('/zakat/{id}/invoice-ready', [ZakatController::class, 'invoiceReady'])->name('zakat.invoice-ready');
});

// ══════════════════════════════════════════════
//  PUBLIK — Form Qurban (tidak perlu login)
// ══════════════════════════════════════════════

// Form Qurban (publik + kasir + admin)
Route::get('/qurban', function () {
    return view('qurban');
});

// Export PDF dan cetak (hanya kasir dan admin, dari form publik atau admin)
Route::post('/qurban/export-pdf', [QurbanController::class, 'exportPdf'])->name('qurban.export-pdf');
// Cetak ulang internal (admin & kasir): butuh login
Route::middleware('admin.auth')->get('/qurban/{id}/cetak', [QurbanController::class, 'cetakUlang'])->name('qurban.cetak-ulang');
// Cetak publik (pembayar via WA): tanpa login
Route::get('/qurban/{id}/invoice', [QurbanController::class, 'publicInvoice'])->name('qurban.public-invoice');
// Halaman invoice-ready (hanya untuk yang login)
Route::middleware('admin.auth')->group(function () {
    Route::get('/qurban/{id}/invoice-ready', [QurbanController::class, 'invoiceReady'])->name('qurban.invoice-ready');
});


// ══════════════════════════════════════════════
//  ADMIN — Login (tidak perlu middleware)
// ══════════════════════════════════════════════

Route::prefix('admin')->name('admin.')->group(function () {

    // Halaman login
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');

    // ── Protected routes (harus login terlebih dahulu) ──
    Route::middleware('admin.auth')->group(function () {

        // ── Dashboard untuk SEMUA ROLE ──
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        // rekap page – available to kasir, pengurus, and admin (all authenticated)
        Route::get('/rekap', [RekapController::class, 'index'])->name('rekap');

        // ── KASIR routes (isi form, upload bukti, export) ──
        Route::middleware([\App\Http\Middleware\KasirRole::class])->group(function () {
            Route::get('/zakat/create', [AdminZakatController::class, 'create'])->name('zakat.create');
            Route::post('/zakat', [AdminZakatController::class, 'store'])->name('zakat.store');
        });

        // ── PENGURUS routes (view-only dashboard). transaksi index/show available to all authenticated roles
        Route::get('/transaksi', [\App\Http\Controllers\TransaksiController::class, 'index'])->name('transaksi');
        Route::get('/transaksi/{id}', [\App\Http\Controllers\TransaksiController::class, 'show'])->name('transaksi.show');

        // update/delete actions will enforce admin/ kasir in controller itself
        Route::put('/transaksi/{id}', [\App\Http\Controllers\TransaksiController::class, 'update'])->name('transaksi.update');
        Route::delete('/transaksi/{id}', [\App\Http\Controllers\TransaksiController::class, 'destroy'])->name('transaksi.destroy');

        // ── QURBAN routes (available to all authenticated roles)
        Route::get('/qurban', [QurbanController::class, 'index'])->name('qurban');
        Route::get('/qurban/{id}', [QurbanController::class, 'show'])->name('qurban.show');
        Route::put('/qurban/{id}', [QurbanController::class, 'update'])->name('qurban.update');
        Route::delete('/qurban/{id}', [QurbanController::class, 'destroy'])->name('qurban.destroy');

        // ── ADMIN routes (full access) ──
        Route::middleware([\App\Http\Middleware\AdminOnly::class])->group(function () {
            // transaksi is already registered above; admin may also edit via same update routes
            Route::get('/laporan', [\App\Http\Controllers\LaporanController::class, 'index'])->name('laporan');
            Route::get('/settings', function () {
                return view('admin.settings');
            })->name('settings');
            Route::get('/akun', function () {
                return view('admin.akun');
            })->name('akun');
            Route::get('/zakat/create', [AdminZakatController::class, 'create'])->name('zakat.create');
            Route::post('/zakat', [AdminZakatController::class, 'store'])->name('zakat.store');
            Route::resource('users', UserController::class);
            Route::patch('users/{user}/toggle', [UserController::class, 'toggleActive'])->name('users.toggleActive');
        });

        // Export rekap milik kasir saat ini (kasir & admin boleh akses)
        Route::get('/laporan/rekap-saya/export', [\App\Http\Controllers\LaporanController::class, 'exportSaya'])->name('laporan.export-saya');

        // ── Logout (bersama untuk semua role) ──
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    });

});
