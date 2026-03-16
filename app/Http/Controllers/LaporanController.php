<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ZakatPenerimaan;
use App\Exports\LaporanExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class LaporanController extends Controller
{
    private array $onlineBanks = ['qris', 'tf', 'transfer', 'bsi', 'mandiri', 'bca', 'bni', 'bri', 'muamalat'];

    public function exportSaya(Request $request)
    {
        // Dapatkan user saat ini dari salah satu guard
        $user = auth('admin')->check() ? auth('admin')->user() : auth('web')->user();
        if (! $user) {
            abort(401);
        }

        $bulan = (int)($request->get('bulan', now()->month));
        $tahun = (int)($request->get('tahun', now()->year));
        $status = $request->get('status');
        $jenis  = $request->get('jenis'); // optional filter by jenis substring
        $nama   = $request->get('nama');  // optional filter by donor name substring
        $metode = strtolower((string) $request->get('metode', ''));

        // Query transaksi milik user ini (created_by)
        $query = ZakatPenerimaan::with('creator')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->where('created_by', $user->id);

        if ($status) {
            $query->where('status', $status);
        }
        if ($nama) {
            $query->where('nama', 'like', "%{$nama}%");
        }
        if ($metode === 'cash') {
            $query->whereRaw('LOWER(COALESCE(bank, "")) = ?', ['cash']);
        } elseif ($metode === 'online') {
            $placeholders = implode(',', array_fill(0, count($this->onlineBanks), '?'));
            $query->whereRaw("LOWER(COALESCE(bank, '')) IN ({$placeholders})", $this->onlineBanks);
        }

        $data = $query->orderBy('tanggal', 'desc')->orderBy('id', 'desc')->get();

        // Jika minta filter jenis, lakukan filter manual pada items
        if ($jenis) {
            $data = $data->filter(function ($row) use ($jenis) {
                $items = is_array($row->items) ? $row->items : json_decode($row->items, true);
                if (empty($items)) return false;
                foreach ($items as $it) {
                    if (str_contains(strtolower($it['jenis'] ?? ''), strtolower($jenis))) {
                        return true;
                    }
                }
                return false;
            });
        }

        $filename = 'Rekap_Saya_' . $user->name . '_' . str_pad($bulan,2,'0',STR_PAD_LEFT) . '-' . $tahun . '.xlsx';

        return Excel::download(new LaporanExport($data), $filename);
    }

    public function index(Request $request)
    {
        $tanggal = $request->get('tanggal');
        $namaKasir = $request->get('nama_kasir');
        $metode = strtolower((string) $request->get('metode', ''));

        // Build query
        $query = ZakatPenerimaan::with('creator');

        if ($tanggal) {
            $query->whereDate('tanggal', $tanggal);
        }

        if ($namaKasir) {
            $query->where(function ($q) use ($namaKasir) {
                $q->whereHas('creator', function ($sub) use ($namaKasir) {
                    $sub->where('name', 'like', "%{$namaKasir}%");
                })->orWhere('nama_amil', 'like', "%{$namaKasir}%");
            });
        }

        if ($metode === 'cash') {
            $query->whereRaw('LOWER(COALESCE(bank, "")) = ?', ['cash']);
        } elseif ($metode === 'online') {
            $placeholders = implode(',', array_fill(0, count($this->onlineBanks), '?'));
            $query->whereRaw("LOWER(COALESCE(bank, '')) IN ({$placeholders})", $this->onlineBanks);
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
                'metode'     => $this->formatMetodePembayaran($row->bank),
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

        return view('admin.laporan', compact('transaksi', 'tanggal', 'namaKasir', 'metode', 'daftarKasir'));
    }

    private function formatMetodePembayaran(?string $bank): string
    {
        $value = strtolower(trim((string) $bank));

        if ($value === 'cash') {
            return 'Cash';
        }

        if ($value === 'qris') {
            return 'QRIS';
        }

        if (in_array($value, $this->onlineBanks, true)) {
            return $value === 'qris' ? 'QRIS' : 'TF';
        }

        return '-';
    }
}
