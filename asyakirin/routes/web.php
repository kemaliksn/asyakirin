<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ZakatController;

Route::post('/export-pdf', [ZakatController::class, 'exportPdf'])
    ->name('export.pdf');

Route::get('/', function () {
    return view('zakat');
});
