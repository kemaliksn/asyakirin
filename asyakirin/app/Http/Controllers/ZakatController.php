<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;   // ✅ PENTING

class ZakatController extends Controller
{
    public function exportPdf(Request $request)
    {
        $items = [];

        if ($request->has('jenis')) {

            foreach ($request->jenis as $key => $jenis) {

                $uang = $request->uang[$key] ?? 0;
                $beras = $request->beras[$key] ?? 0;

                // hanya ambil yang ada nominalnya
                if ($uang > 0 || $beras > 0) {
                    $items[] = [
                        'jenis' => $jenis,
                        'uang' => $uang,
                        'beras' => $beras,
                    ];
                }
            }
        }

        $data = [
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'telpon' => $request->telpon,
            'profesi' => $request->profesi,
            'jumlah_jiwa' => $request->jumlah_jiwa,
            'atas_nama' => $request->atas_nama ?? [],
            'bank' => $request->bank,
            'items' => $items
        ];

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.zakat', compact('data'))
                ->setPaper('A4', 'landscape');

        return $pdf->download('tanda-terima-zakat.pdf');
    }
}
