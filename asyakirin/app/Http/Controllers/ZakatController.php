<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Helpers\ZakatHelper;
use App\Models\ZakatPenerimaan;

class ZakatController extends Controller
{
    /**
     * Simpan data ke DB lalu generate PDF tanda terima.
     * Route: POST /zakat/export-pdf
     */
    public function exportPdf(Request $request)
    {
        // ── 1. Kumpulkan item zakat ──────────────────────────────────
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

        // ── 2. Hitung terbilang & generate nomor ────────────────────
        $terbilang = ZakatHelper::terbilang($totalUang);
        $nomor     = ZakatHelper::generateNomor(); // ASY/26/UPZ/0001, dst
        $tahun     = date('y');

        // ── 3. Simpan ke database ────────────────────────────────────
        ZakatPenerimaan::create([
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
            'nama_amil'   => $request->nama_amil ?? '',
            'tanggal'     => now()->toDateString(),
            'tahun'       => $tahun,
        ]);

        // ── 4. Susun data untuk blade ────────────────────────────────
        $data = [
            'nomor'       => $nomor,
            'nama'        => $request->nama,
            'alamat'      => $request->alamat,
            'telpon'      => $request->telpon,
            'profesi'     => $request->profesi,
            'jumlah_jiwa' => $request->jumlah_jiwa,
            'atas_nama'   => $request->atas_nama ?? [],
            'items'       => $items,
            'terbilang'   => $terbilang,
            'tanggal'     => now()->isoFormat('D MMMM Y'), // ex: 17 Februari 2026
            'nama_amil'   => $request->nama_amil ?? '',
        ];

        // ── 5. Generate & return PDF ─────────────────────────────────
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

        return $pdf->stream('tanda-terima-zakat.pdf');
        // Ganti ->stream() dengan ->download() untuk langsung download
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