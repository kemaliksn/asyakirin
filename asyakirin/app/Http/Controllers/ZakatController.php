<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Helpers\ZakatHelper;
use App\Models\ZakatPenerimaan;
use Illuminate\Support\Facades\DB;

class ZakatController extends Controller
{
    /**
     * Simpan data ke DB lalu generate PDF tanda terima.
     * Route: POST /zakat/export-pdf
     */

    public function exportPdf(Request $request)
    {
        // validasi minimal: selalu periksa keberadaan field utama. Bukti hanya wajib
        // untuk donatur yang mengisi sendiri (tidak login sebagai kasir/admin).
        $rules = [
            'nama'        => 'required|string|max:100',
            'jumlah_jiwa' => 'required|integer|min:1',
            'jenis'       => 'required|array|min:1',
            'uang'        => 'array',
            'beras'       => 'array',
        ];

        if (auth('web')->check() || auth('admin')->check()) {
            $rules['bukti'] = 'nullable|image|max:2048';
        } else {
            $rules['bukti'] = 'required|image|max:2048';
        }

        $request->validate($rules);

        $items      = [];
        $totalUang  = 0;
        $totalBeras = 0;

        if ($request->has('jenis')) {
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
        }

        $terbilang = ZakatHelper::terbilang($totalUang);
        $tahun     = date('y');

        // apakah ada siapa pun login (kasir atau admin) agar status bisa otomatis Lunas
        $isLogged = auth('web')->check() || auth('admin')->check();

        // tangkap ID pengurus hanya dari guard web (kasir). admin tidak disimpan
        $createdBy = auth('web')->check() ? auth('web')->id() : null;

        // nama amil = nama user yang login (web atau admin) atau input manual
        if (auth('web')->check()) {
            $namaAmil = auth('web')->user()->name;
        } elseif (auth('admin')->check()) {
            $namaAmil = auth('admin')->user()->name;
        } else {
            $namaAmil = $request->nama_amil ?? '';
        }


        // 🔥 SIMPAN DULU DALAM TRANSACTION
        // jika ada file bukti, simpan terlebih dahulu
        $buktiPath = null;
        if ($request->hasFile('bukti')) {
            $buktiPath = $request->file('bukti')->store('bukti', 'public');
        }

        $zakat = DB::transaction(function () use (
            $request,
            $items,
            $totalUang,
            $totalBeras,
            $terbilang,
            $tahun,
            $isLogged,
            $createdBy,  // ← pass ke dalam closure
            $buktiPath,
            $namaAmil
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
                'nama_amil'   => $namaAmil,
                'tanggal'     => now()->toDateString(),
                'tahun'       => $tahun,

                // status otomatis berdasarkan login
                'status'      => $isLogged ? 'Lunas' : 'Belum Lunas',

                // ✅ Auto-detect: kalau ada user login = kasir, kalau tidak = donatur langsung
                'created_by'  => $createdBy, // NULL kalau donatur langsung, ID kasir kalau login
                'bukti'       => $buktiPath,
            ]);
        });

        // Generate PDF seperti biasa...
        $data = [
            'nomor'       => $zakat->nomor,
            'nama'        => $zakat->nama,
            'alamat'      => $zakat->alamat,
            'telpon'      => $zakat->telpon,
            'profesi'     => $zakat->profesi,
            'jumlah_jiwa' => $zakat->jumlah_jiwa,
            'atas_nama'   => $zakat->atas_nama ?? [],
            'items'       => $zakat->items ?? [],
            'terbilang'   => $zakat->terbilang,
            'tanggal'     => now()->isoFormat('D MMMM Y'),
            'nama_amil'   => $zakat->nama_amil,
        ];
        $pdf = Pdf::loadView('pdf.zakat', compact('data'))
            ->setPaper('A4', 'landscape');

        return $pdf->download('tanda-terima-zakat.pdf');
    }

    /**
     * Cetak ulang PDF dari data yang sudah tersimpan di DB.
     * Route: GET /zakat/{id}/cetak
     */
    public function cetakUlang(int $id)
    {
        $zakat = ZakatPenerimaan::findOrFail($id);

        $data = [
            'nomor'       => $zakat->nomor,
            'nama'        => $zakat->nama,
            'alamat'      => $zakat->alamat,
            'telpon'      => $zakat->telpon,
            'profesi'     => $zakat->profesi,
            'jumlah_jiwa' => $zakat->jumlah_jiwa,
            'atas_nama'   => $zakat->atas_nama ?? [],
            'items'       => $zakat->items     ?? [],
            'terbilang'   => $zakat->terbilang,
            'tanggal'     => $zakat->tanggal->isoFormat('D MMMM Y'),
            'nama_amil'   => $zakat->nama_amil,
        ];

        $pdf = Pdf::loadView('pdf.zakat', compact('data'))
            ->setPaper('A4', 'landscape')
            ->setOption([
                'defaultFont'          => 'DejaVu Sans',
                'isRemoteEnabled'      => true,
                'isHtml5ParserEnabled' => true,
                'dpi'                  => 150,
                'margin_top'           => 0,
                'margin_right'         => 0,
                'margin_bottom'        => 0,
                'margin_left'          => 0,
            ]);

        return $pdf->stream('tanda-terima-' . $zakat->nomor . '.pdf');
    }
}
