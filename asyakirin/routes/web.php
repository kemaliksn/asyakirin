<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ZakatController;

// Export PDF baru (simpan ke DB dulu, lalu buka PDF)
Route::post('/zakat/export-pdf', [ZakatController::class, 'exportPdf'])->name('zakat.export-pdf');

// Cetak ulang PDF dari data yang sudah ada di DB
Route::get('/zakat/{id}/cetak', [ZakatController::class, 'cetakUlang'])->name('zakat.cetak-ulang');

Route::post('/export-pdf', [ZakatController::class, 'exportPdf'])
    ->name('export.pdf');

Route::get('/', function () {
    return view('zakat');
});

// ── Admin Dashboard ──
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboardadmin'); // ← taruh blade di resources/views/admin/
    })->name('dashboard');

    Route::get('/transaksi', function () {
        return view('admin.transaksi');
    })->name('transaksi');

    Route::get('/laporan', function () {
        return view('admin.laporan');
    })->name('laporan');

    Route::get('/rekap', function () {
        return view('admin.rekap');
    })->name('rekap');

    Route::get('/settings', function () {
        return view('admin.settings');
    })->name('settings');

    Route::get('/akun', function () {
        return view('admin.akun');
    })->name('akun');

    Route::post('/logout', function () {
        return redirect('/');
    })->name('logout');
});