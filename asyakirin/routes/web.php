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
