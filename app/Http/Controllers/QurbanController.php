<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Helpers\ZakatHelper;
use App\Models\QurbanPenerimaan;
use Illuminate\Support\Facades\DB;

class QurbanController extends Controller
{
    /**
     * Simpan data ke DB lalu generate PDF tanda terima.
     * Route: POST /qurban/export-pdf
     */

    public function exportPdf(Request $request)
    {
        // validasi minimal: selalu periksa keberadaan field utama. Bukti hanya wajib
        // untuk pembayar yang mengisi sendiri (tidak login sebagai kasir/admin).
        $rules = [
            'nama'        => 'required|string|max:100',
            'jenis'       => 'required|array|min:1',
            'uang'        => 'array',
        ];

        // optional payment method
        $rules['bank'] = 'nullable|string|max:50';

        if (auth('web')->check() || auth('admin')->check()) {
            $rules['bukti'] = 'nullable|image|max:2048';
        } else {
            $rules['bukti'] = 'required|image|max:2048';
        }

        $request->validate($rules);

        $items      = [];
        $totalUang  = 0;

        if ($request->has('jenis')) {
            foreach ($request->jenis as $key => $jenis) {
                $uang  = (float) ($request->uang[$key]  ?? 0);
                $keterangan = $request->keterangan[$key] ?? '';

                $items[] = [
                    'jenis'       => $jenis,
                    'keterangan'  => $keterangan,
                    'uang'        => $uang,
                ];

                $totalUang  += $uang;
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

        $qurban = DB::transaction(function () use (
            $request,
            $items,
            $totalUang,
            $terbilang,
            $tahun,
            $isLogged,
            $createdBy,  // ← pass ke dalam closure
            $buktiPath,
            $namaAmil
        ) {

            // tanggal tetap untuk perhitungan & simpan
            $today = now()->toDateString();

            // nomor urut harian per kasir/petugas — prefer created_by jika ada; fallback ke nama_amil
            $dailySeq = null;
            if (!empty($createdBy)) {
                $existingCount = QurbanPenerimaan::where('created_by', $createdBy)
                    ->where('tanggal', $today)
                    ->lockForUpdate()
                    ->count();
                $dailySeq = $existingCount + 1;
            } else {
                // Jika login via guard admin atau created_by tidak terisi, gunakan nama_amil sebagai identitas petugas
                if (!empty($namaAmil)) {
                    $existingCount = QurbanPenerimaan::where('nama_amil', $namaAmil)
                        ->where('tanggal', $today)
                        ->lockForUpdate()
                        ->count();
                    $dailySeq = $existingCount + 1;
                }
            }

            $last = QurbanPenerimaan::where('tahun', $tahun)
                ->orderBy('id', 'desc')
                ->lockForUpdate()
                ->first();

            $nextNumber = 1;

            if ($last) {
                $lastNumber = (int) substr($last->nomor, -4);
                $nextNumber = $lastNumber + 1;
            }

            $nomor = "ASY/$tahun/QRB/" . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

            return QurbanPenerimaan::create([
                'nomor'          => $nomor,
                'nama'           => $request->nama,
                'alamat'         => $request->alamat,
                'telpon'         => $request->telpon,
                'profesi'        => $request->profesi,
                'items'          => $items,
                'total_uang'     => (int) $totalUang,
                'terbilang'      => $terbilang,
                'nama_amil'      => $namaAmil,
                'daily_sequence' => $dailySeq,
                'tanggal'        => $today,
                'tahun'          => $tahun,

                // status otomatis berdasarkan login
                'status'      => $isLogged ? 'Lunas' : 'Belum Lunas',

                // ✅ Auto-detect: kalau ada user login = kasir, kalau tidak = pembayar langsung
                'created_by'  => $createdBy, // NULL kalau pembayar langsung, ID kasir kalau login
                'bukti'       => $buktiPath,
                'bank'        => $request->bank ?? null,
            ]);
        });

        // Generate PDF seperti biasa...
        $data = [
            'nomor'          => $qurban->nomor,
            'nama'           => $qurban->nama,
            'alamat'         => $qurban->alamat,
            'telpon'         => $qurban->telpon,
            'profesi'        => $qurban->profesi,
            'items'          => $qurban->items ?? [],
            'bank'           => $qurban->bank ?? null,
            'terbilang'      => $qurban->terbilang,
            'tanggal'        => now()->isoFormat('D MMMM Y'),
            'nama_amil'      => $qurban->nama_amil,
            'daily_sequence' => $qurban->daily_sequence,
        ];
        $pdf = Pdf::loadView('pdf.qurban', compact('data'))
            ->setPaper('A5', 'landscape')
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

        $filename = str_replace(['/', '\\'], '-', $qurban->nomor) . '.pdf';

        // Jika kasir/admin sedang login, arahkan ke halaman invoice-ready (tanpa langsung download)
        if (auth('web')->check() || auth('admin')->check()) {
            return redirect()->route('qurban.invoice-ready', $qurban->id);
        }

        // Publik (pembayar) tetap langsung download
        return $pdf->download($filename);
    }

    /**
     * Cetak ulang PDF dari data yang sudah tersimpan di DB.
     * HANYA ADMIN dan KASIR yang boleh mengakses fitur ini.
     * Route: GET /qurban/{id}/cetak
     */
    public function cetakUlang(int $id)
    {
        // Izinkan ADMIN dan KASIR mencetak ulang
        $isAdmin = (auth('admin')->check() && auth('admin')->user()->role === 'admin')
            || (auth('web')->check() && auth('web')->user()->role === 'admin');

        $isKasir = (auth('admin')->check() && auth('admin')->user()->role === 'kasir')
            || (auth('web')->check() && auth('web')->user()->role === 'kasir');

        if (!($isAdmin || $isKasir)) {
            abort(403, 'Akses ditolak. Hanya admin atau kasir yang dapat mencetak ulang invoice.');
        }

        $qurban = QurbanPenerimaan::findOrFail($id);

        $data = [
            'nomor'          => $qurban->nomor,
            'nama'           => $qurban->nama,
            'alamat'         => $qurban->alamat,
            'telpon'         => $qurban->telpon,
            'profesi'        => $qurban->profesi,
            'items'          => $qurban->items ?? [],
            'bank'           => $qurban->bank ?? null,
            'terbilang'      => $qurban->terbilang,
            'tanggal'        => $qurban->tanggal->isoFormat('D MMMM Y'),
            'nama_amil'      => $qurban->nama_amil,
            'daily_sequence' => $qurban->daily_sequence,
        ];

        $pdf = Pdf::loadView('pdf.qurban', compact('data'))
            ->setPaper('A5', 'landscape')
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

        $filename = str_replace(['/', '\\'], '-', $qurban->nomor) . '.pdf';
        return $pdf->stream($filename);
    }

    /**
     * Cetak/unduh invoice publik tanpa login (untuk pembayar via tautan WA)
     * Route: GET /qurban/{id}/invoice
     */
    public function publicInvoice(int $id)
    {
        $qurban = QurbanPenerimaan::findOrFail($id);

        $data = [
            'nomor'          => $qurban->nomor,
            'nama'           => $qurban->nama,
            'alamat'         => $qurban->alamat,
            'telpon'         => $qurban->telpon,
            'profesi'        => $qurban->profesi,
            'items'          => $qurban->items ?? [],
            'bank'           => $qurban->bank ?? null,
            'terbilang'      => $qurban->terbilang,
            'tanggal'        => $qurban->tanggal->isoFormat('D MMMM Y'),
            'nama_amil'      => $qurban->nama_amil,
            'daily_sequence' => $qurban->daily_sequence,
        ];

        $pdf = Pdf::loadView('pdf.qurban', compact('data'))
            ->setPaper('A5', 'landscape')
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

        $filename = str_replace(['/', '\\'], '-', $qurban->nomor) . '.pdf';
        return $pdf->stream($filename);
    }

    /**
     * Halaman konfirmasi setelah simpan (untuk kasir/admin):
     * berisi tombol Download Invoice & Kirim via WhatsApp
     */
    public function invoiceReady(int $id)
    {
        $qurban = QurbanPenerimaan::findOrFail($id);
        return view('invoice-ready-qurban', compact('qurban'));
    }

    /**
     * Daftar data qurban yang sudah diinput
     * Route: GET /admin/qurban
     */
    public function index(Request $request)
    {
        $query = QurbanPenerimaan::query();

        // Filter by nama
        if ($request->has('nama') && !empty($request->nama)) {
            $query->where('nama', 'like', '%' . $request->nama . '%');
        }

        // Filter by status
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Filter by tanggal (date range)
        if ($request->has('dari_tanggal') && !empty($request->dari_tanggal)) {
            $query->whereDate('tanggal', '>=', $request->dari_tanggal);
        }
        if ($request->has('sampai_tanggal') && !empty($request->sampai_tanggal)) {
            $query->whereDate('tanggal', '<=', $request->sampai_tanggal);
        }

        // Sort by tanggal descending
        $qurbans = $query->orderBy('tanggal', 'desc')->paginate(20);

        // Stats
        $totalRecord = QurbanPenerimaan::count();
        $totalUang = QurbanPenerimaan::sum('total_uang');
        $lunas = QurbanPenerimaan::where('status', 'Lunas')->count();
        $belumLunas = QurbanPenerimaan::where('status', 'Belum Lunas')->count();
        $batal = QurbanPenerimaan::where('status', 'Batal')->count();

        return view('admin.qurban-list', compact(
            'qurbans',
            'totalRecord',
            'totalUang',
            'lunas',
            'belumLunas',
            'batal'
        ));
    }

    /**
     * Lihat detail qurban
     * Route: GET /admin/qurban/{id}
     */
    public function show(int $id)
    {
        $qurban = QurbanPenerimaan::with('creator')->findOrFail($id);
        return view('admin.qurban-detail', compact('qurban'));
    }

    /**
     * Update qurban data
     * Route: PUT /admin/qurban/{id}
     */
    public function update(Request $request, int $id)
    {
        $user = auth('admin')->check() ? auth('admin')->user() : auth('web')->user();
        if (!$user || !in_array($user->role, ['admin', 'kasir'])) {
            abort(403);
        }

        $request->validate([
            'nama'        => 'required|string|max:100',
            'alamat'      => 'nullable|string|max:200',
            'telpon'      => 'nullable|string|max:30',
            'profesi'     => 'nullable|string|max:100',
            'status'      => 'required|in:Lunas,Belum Lunas,Batal',
            'tanggal'     => 'required|date',
            'bukti'       => 'nullable|image|max:2048',
        ]);

        $qurban = QurbanPenerimaan::findOrFail($id);

        if ($request->hasFile('bukti')) {
            // remove old file if exists
            if ($qurban->bukti) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($qurban->bukti);
            }
            $qurban->bukti = $request->file('bukti')->store('bukti', 'public');
        }

        $qurban->update($request->only([
            'nama',
            'alamat',
            'telpon',
            'profesi',
            'status',
            'tanggal',
        ]));

        return redirect()->route('admin.qurban.show', $id)
                         ->with('success', 'Data qurban berhasil diperbarui.');
    }

    /**
     * Delete qurban data
     * Route: DELETE /admin/qurban/{id}
     */
    public function destroy(int $id)
    {
        $user = auth('admin')->check() ? auth('admin')->user() : auth('web')->user();
        if (!$user || !in_array($user->role, ['admin', 'kasir'])) {
            abort(403);
        }

        $qurban = QurbanPenerimaan::findOrFail($id);
        if ($qurban->bukti) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($qurban->bukti);
        }
        $qurban->delete();

        return redirect()->route('admin.qurban')
                         ->with('success', 'Data qurban berhasil dihapus.');
    }
}
