<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ZakatPenerimaan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $now        = Carbon::now();
        $today      = $now->toDateString();
        $bulanIni   = $now->month;
        $tahunIni   = $now->year;
        $tahun2digit = $now->format('y'); // "26"

        // ── 1. STAT CARDS ──────────────────────────────────────────

        // Total uang masuk hari ini (status Lunas)
        $totalHariIni = ZakatPenerimaan::whereDate('tanggal', $today)
            ->where('status', 'Lunas')
            ->sum('total_uang');

        // Total uang masuk bulan ini (status Lunas)
        $totalBulanIni = ZakatPenerimaan::whereMonth('tanggal', $bulanIni)
            ->whereYear('tanggal', $tahunIni)
            ->where('status', 'Lunas')
            ->sum('total_uang');

        // Total pengumpulan sepanjang tahun ini (status Lunas)
        $totalPengumpulan = ZakatPenerimaan::whereYear('tanggal', $tahunIni)
            ->where('status', 'Lunas')
            ->sum('total_uang');

        // Total donatur unik (berdasarkan nama + telpon)
        $totalDonatur = ZakatPenerimaan::whereYear('tanggal', $tahunIni)
            ->distinct('telpon')
            ->count('telpon');

        // Total jiwa yang membayar zakat bulan ini
        $totalJiwa = ZakatPenerimaan::whereMonth('tanggal', $bulanIni)
            ->whereYear('tanggal', $tahunIni)
            ->where('status', 'Lunas')
            ->sum('jumlah_jiwa');


        // ── 2. TRANSAKSI TERBARU (5 data terakhir) ─────────────────

        // AdminDashboardController.php
        $transaksi = ZakatPenerimaan::with('creator') // ← eager load relasi
        ->orderBy('created_at', 'desc')
        ->limit(10)
        ->get()
        ->map(function ($row) {
            $items = is_array($row->items) ? $row->items : json_decode($row->items, true);
            $jenisLabel = '';
            if (!empty($items)) {
                $jenisList = array_column($items, 'jenis');
                $jenisLabel = implode(', ', array_unique($jenisList));
            }

            return (object)[
                'id'         => $row->id,
                'invoice'    => $row->nomor,
                'nama'       => $row->nama,
                'jenis'      => $jenisLabel,
                'nominal'    => $row->total_uang,
                'status'     => $row->status,
                'tanggal'    => Carbon::parse($row->tanggal)->translatedFormat('d M Y'),
                'input_by'   => $row->creator ? $row->creator->name : 'Donatur', // ← info siapa yang input
            ];
        });


        // ── 3. STATISTIK PER JENIS (bulan ini) ────────────────────
        // items adalah JSON array of objects: [{"jenis":"Zakat Fitrah","uang":10000,"beras":2}]
        // Kita aggregate dengan cara yang kompatibel MySQL & SQLite

        $semuaData = ZakatPenerimaan::whereMonth('tanggal', $bulanIni)
            ->whereYear('tanggal', $tahunIni)
            ->where('status', 'Lunas')
            ->get(['items']);

        $statJenis = [
            'Zakat Fitrah'    => 0,
            'Zakat Maal'      => 0,
            'Infaq'           => 0,
            'Yatim'           => 0,
            'Fidyah'          => 0,
        ];

        foreach ($semuaData as $row) {
            $items = is_array($row->items) ? $row->items : json_decode($row->items, true);
            if (!$items) continue;

            foreach ($items as $item) {
                $jenis = $item['jenis'] ?? '';
                $uang  = (int)($item['uang'] ?? 0);

                if (str_contains($jenis, 'Fitrah'))           $statJenis['Zakat Fitrah'] += $uang;
                elseif (str_contains($jenis, 'Maal'))         $statJenis['Zakat Maal']   += $uang;
                elseif (str_contains($jenis, 'Infaq')
                     || str_contains($jenis, 'Shodaqoh'))     $statJenis['Infaq']         += $uang;
                elseif (str_contains($jenis, 'Yatim'))        $statJenis['Yatim']         += $uang;
                elseif (str_contains($jenis, 'Fidyah'))       $statJenis['Fidyah']        += $uang;
            }
        }


        // ── 4. CHART BULANAN (Jan–Des tahun ini) ──────────────────

        $bulananRaw = ZakatPenerimaan::selectRaw('MONTH(tanggal) as bulan, SUM(total_uang) as total')
            ->whereYear('tanggal', $tahunIni)
            ->where('status', 'Lunas')
            ->groupBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();

        // Pastikan semua 12 bulan ada (isi 0 jika belum ada data)
        $chartBulanan = [];
        for ($m = 1; $m <= 12; $m++) {
            $chartBulanan[] = $bulananRaw[$m] ?? 0;
        }

        // ── 5. NOMOR WA ADMIN (dari config/env) ───────────────────
        $noWa = config('app.admin_wa', env('ADMIN_WA', '6281234567890'));


        return view('admin.dashboardadmin', compact(
            'totalHariIni',
            'totalBulanIni',
            'totalPengumpulan',
            'totalDonatur',
            'totalJiwa',
            'transaksi',
            'statJenis',
            'chartBulanan',
            'noWa',
        ));
    }
}
