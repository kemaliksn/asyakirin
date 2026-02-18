<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ZakatPenerimaan;
use App\Helpers\ZakatHelper;
use Illuminate\Support\Facades\DB;

class AdminZakatController extends Controller
{
    /**
     * Tampilkan form input zakat untuk pengurus
     */
    public function create()
    {
        return view('admin.zakat.create');
    }

    /**
     * Simpan data zakat yang diinput oleh pengurus
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'        => 'required|string|max:100',
            'alamat'      => 'nullable|string',
            'telpon'      => 'nullable|string|max:20',
            'profesi'     => 'nullable|string|max:100',
            'jumlah_jiwa' => 'required|integer|min:1',
            'atas_nama'   => 'nullable|array',
            'jenis'       => 'required|array|min:1',
            'uang'        => 'required|array',
            'beras'       => 'nullable|array',
            'nama_amil'   => 'nullable|string|max:100',
        ]);

        // Kumpulkan items
        $items      = [];
        $totalUang  = 0;
        $totalBeras = 0;

        foreach ($request->jenis as $key => $jenis) {
            $uang  = (float) ($request->uang[$key]  ?? 0);
            $beras = (float) ($request->beras[$key] ?? 0);

            $items[] = [
                'jenis' => $jenis,
                'uang'  => $uang,
                'beras' => $beras,
            ];

            $totalUang  += $uang;
            $totalBeras += $beras;
        }

        $terbilang = ZakatHelper::terbilang($totalUang);
        $tahun     = date('y');

        // Simpan dalam transaction
        $zakat = DB::transaction(function () use (
            $request,
            $items,
            $totalUang,
            $totalBeras,
            $terbilang,
            $tahun
        ) {
            $last = ZakatPenerimaan::where('tahun', $tahun)
                ->orderBy('id', 'desc')
                ->lockForUpdate()
                ->first();

            $nextNumber = 1;

            if ($last) {
                $lastNumber = (int) substr($last->nomor, -4);
                $nextNumber = $lastNumber + 1;
            }

            $nomor = "ASY/$tahun/UPZ/" . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

            return ZakatPenerimaan::create([
                'nomor'       => $nomor,
                'nama'        => $request->nama,
                'alamat'      => $request->alamat,
                'telpon'      => $request->telpon,
                'profesi'     => $request->profesi,
                'jumlah_jiwa' => (int) $request->jumlah_jiwa,
                'atas_nama'   => $request->atas_nama ?? [],
                'items'       => $items,
                'total_uang'  => (int) $totalUang,
                'total_beras' => $totalBeras,
                'terbilang'   => $terbilang,
                'nama_amil'   => $request->nama_amil ?? auth('admin')->user()->name,
                'tanggal'     => now()->toDateString(),
                'status'      => 'Lunas', // Langsung lunas karena diinput pengurus
                'tahun'       => $tahun,
                'created_by'  => auth('admin')->id(), // ← ID pengurus yang input
            ]);
        });

        return redirect()->route('admin.transaksi')
            ->with('success', "Data zakat berhasil ditambahkan! Nomor: {$zakat->nomor}");
    }
}
