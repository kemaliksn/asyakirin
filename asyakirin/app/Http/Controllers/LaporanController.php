<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ZakatPenerimaan;
use App\Exports\LaporanExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->get('tanggal');
        $namaKasir = $request->get('nama_kasir');

        // Build query
        $query = ZakatPenerimaan::with('creator');

        if ($tanggal) {
            $query->whereDate('tanggal', $tanggal);
        }

        if ($namaKasir) {
            $query->whereHas('creator', function ($q) use ($namaKasir) {
                $q->where('name', 'like', "%{$namaKasir}%");
            })->orWhere('nama_amil', 'like', "%{$namaKasir}%");
        }

        $data = $query->orderBy('tanggal', 'desc')->orderBy('id', 'desc')->get();

        // Transform untuk view
        $transaksi = $data->map(function ($row) {
            $items = is_array($row->items) ? $row->items : json_decode($row->items, true);
            $jenisLabel = '';
            if (!empty($items)) {
                $jenisList = array_column($items, 'jenis');
                $jenisLabel = implode(', ', array_unique($jenisList));
            }

            // Tentukan nama input
            if ($row->created_by && $row->creator) {
                $inputBy = $row->creator->name;
            } else {
                $inputBy = $row->nama_amil ?: 'Donatur';
            }

            return (object)[
                'id'         => $row->id,
                'nomor'      => $row->nomor,
                'nama'       => $row->nama,
                'alamat'     => $row->alamat,
                'telpon'     => $row->telpon,
                'profesi'    => $row->profesi,
                'jumlah_jiwa' => $row->jumlah_jiwa,
                'jenis'      => $jenisLabel,
                'total_uang' => $row->total_uang,
                'total_beras' => $row->total_beras,
                'status'     => $row->status,
                'tanggal'    => Carbon::parse($row->tanggal)->translatedFormat('d M Y'),
                'input_by'   => $inputBy,
            ];
        });

        // Jika request export ke Excel
        if ($request->get('export') === 'excel') {
            $filename = 'Laporan_Zakat_' . ($tanggal ? str_replace('-', '_', $tanggal) : date('Y-m-d')) . '.xlsx';
            // Kirim data model asli (mengandung items) agar export bisa pecah per-jenis
            return Excel::download(new LaporanExport($data, $tanggal, $namaKasir), $filename);
        }

        // Daftar kasir unik untuk dropdown filter
        $daftarKasir = ZakatPenerimaan::selectRaw('COALESCE(nama_amil, \'Donatur\') as kasir')
            ->distinct()
            ->pluck('kasir')
            ->sort()
            ->values();

        return view('admin.laporan', compact('transaksi', 'tanggal', 'namaKasir', 'daftarKasir'));
    }
}
