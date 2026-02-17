<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ZakatPenerimaan;
use Carbon\Carbon;

class RekapController extends Controller
{
    public function index(Request $request)
    {
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;

        // ── Filter params ──
        $filterJenis   = $request->get('jenis', '');
        $filterStatus  = $request->get('status', '');
        $filterBulan   = $request->get('bulan', $bulanIni);
        $filterTahun   = $request->get('tahun', $tahunIni);
        $filterNama    = $request->get('nama', '');

        // ── Stat cards per jenis (bulan ini, lunas) ──
        $semuaBulanIni = ZakatPenerimaan::whereMonth('tanggal', $filterBulan)
            ->whereYear('tanggal', $filterTahun)
            ->where('status', 'Lunas')
            ->get(['items']);

        $statJenis = [
            'Zakat Fitrah'    => 0,
            'Zakat Maal'      => 0,
            'Infaq/Shodaqoh'  => 0,
            'Yatim'           => 0,
            'Fidyah'          => 0,
        ];

        foreach ($semuaBulanIni as $row) {
            $items = is_array($row->items) ? $row->items : json_decode($row->items, true);
            if (!$items) continue;
            foreach ($items as $item) {
                $j = $item['jenis'] ?? '';
                $u = (int)($item['uang'] ?? 0);
                if (str_contains($j, 'Fitrah'))                          $statJenis['Zakat Fitrah']   += $u;
                elseif (str_contains($j, 'Maal'))                        $statJenis['Zakat Maal']     += $u;
                elseif (str_contains($j, 'Infaq') || str_contains($j, 'Shodaqoh')) $statJenis['Infaq/Shodaqoh'] += $u;
                elseif (str_contains($j, 'Yatim'))                       $statJenis['Yatim']          += $u;
                elseif (str_contains($j, 'Fidyah'))                      $statJenis['Fidyah']         += $u;
            }
        }

        // ── Query transaksi dengan filter ──
        $query = ZakatPenerimaan::query()
            ->whereMonth('tanggal', $filterBulan)
            ->whereYear('tanggal', $filterTahun)
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc');

        if ($filterStatus) {
            $query->where('status', $filterStatus);
        }

        if ($filterNama) {
            $query->where('nama', 'like', '%' . $filterNama . '%');
        }

        // Ambil semua, lalu flatten items jadi per-baris per jenis
        $rawData = $query->get();

        // Flatten: satu record bisa punya banyak jenis → tampilkan per baris
        $rows = collect();
        foreach ($rawData as $record) {
            $items = is_array($record->items) ? $record->items : json_decode($record->items, true);
            if (empty($items)) continue;

            foreach ($items as $item) {
                $jenis = $item['jenis'] ?? '-';
                $uang  = (int)($item['uang'] ?? 0);

                // Filter jenis
                if ($filterJenis && !str_contains(strtolower($jenis), strtolower($filterJenis))) {
                    continue;
                }

                $rows->push((object)[
                    'id'      => $record->id,
                    'invoice' => $record->nomor,
                    'nama'    => $record->nama,
                    'jenis'   => $jenis,
                    'nominal' => $uang,
                    'status'  => $record->status,
                    'tanggal' => Carbon::parse($record->tanggal)->translatedFormat('d F Y'),
                ]);
            }
        }

        // Manual pagination
        $perPage     = 10;
        $currentPage = (int)($request->get('page', 1));
        $total       = $rows->count();
        $items       = $rows->forPage($currentPage, $perPage)->values();
        $lastPage    = max(1, (int)ceil($total / $perPage));

        // Daftar bulan untuk dropdown
        $daftarBulan = collect(range(1, 12))->mapWithKeys(fn($m) => [
            $m => Carbon::create(null, $m)->translatedFormat('F')
        ]);

        return view('admin.rekap', compact(
            'statJenis',
            'items',
            'total',
            'currentPage',
            'lastPage',
            'perPage',
            'filterJenis',
            'filterStatus',
            'filterBulan',
            'filterTahun',
            'filterNama',
            'daftarBulan',
        ));
    }
}