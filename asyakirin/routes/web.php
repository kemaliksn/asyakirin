<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ZakatController;
use App\Http\Controllers\AdminDashboardController;

Route::post('/zakat/export-pdf', [ZakatController::class, 'exportPdf'])->name('zakat.export-pdf');
Route::get('/zakat/{id}/cetak', [ZakatController::class, 'cetakUlang'])->name('zakat.cetak-ulang');
Route::post('/export-pdf', [ZakatController::class, 'exportPdf'])->name('export.pdf');

Route::get('/', function () {
    return view('zakat');
});

// ── Admin ──
Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/transaksi', function () {
        return view('admin.transaksi');
    })->name('transaksi');

    // ✅ Tambahkan ini
    Route::get('/transaksi/{id}', function ($id) {
        return view('admin.transaksi-detail', ['id' => $id]);
    })->name('transaksi.show');

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