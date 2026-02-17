<?php

namespace App\Helpers;

use App\Models\ZakatPenerimaan;

class ZakatHelper
{
    // ─────────────────────────────────────────────────────────────────
    // TERBILANG — Rupiah saja
    // ─────────────────────────────────────────────────────────────────

    private static array $satuan = [
        '', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima',
        'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh',
        'Sebelas', 'Dua Belas', 'Tiga Belas', 'Empat Belas',
        'Lima Belas', 'Enam Belas', 'Tujuh Belas', 'Delapan Belas', 'Sembilan Belas',
    ];

    private static function konversi(int $n): string
    {
        if ($n < 20)  return self::$satuan[$n];
        if ($n < 100) {
            [$s, $r] = [intdiv($n, 10), $n % 10];
            return self::$satuan[$s] . ' Puluh' . ($r ? ' ' . self::$satuan[$r] : '');
        }
        if ($n < 200) {
            $r = $n - 100;
            return 'Seratus' . ($r ? ' ' . self::konversi($r) : '');
        }
        if ($n < 1_000) {
            [$s, $r] = [intdiv($n, 100), $n % 100];
            return self::$satuan[$s] . ' Ratus' . ($r ? ' ' . self::konversi($r) : '');
        }
        if ($n < 2_000) {
            $r = $n - 1_000;
            return 'Seribu' . ($r ? ' ' . self::konversi($r) : '');
        }
        if ($n < 1_000_000) {
            [$s, $r] = [intdiv($n, 1_000), $n % 1_000];
            return self::konversi($s) . ' Ribu' . ($r ? ' ' . self::konversi($r) : '');
        }
        if ($n < 1_000_000_000) {
            [$s, $r] = [intdiv($n, 1_000_000), $n % 1_000_000];
            return self::konversi($s) . ' Juta' . ($r ? ' ' . self::konversi($r) : '');
        }
        [$s, $r] = [intdiv($n, 1_000_000_000), $n % 1_000_000_000];
        return self::konversi($s) . ' Miliar' . ($r ? ' ' . self::konversi($r) : '');
    }

    /**
     * Ubah nominal ke teks terbilang rupiah.
     *
     * Contoh:
     *   10000    → "Sepuluh Ribu Rupiah"
     *   160000   → "Seratus Enam Puluh Ribu Rupiah"
     *   2500000  → "Dua Juta Lima Ratus Ribu Rupiah"
     *   0        → "Nol Rupiah"
     */
    public static function terbilang(int|float $nominal): string
    {
        $nominal = (int) $nominal;
        if ($nominal === 0) return 'Nol Rupiah';
        return self::konversi($nominal) . ' Rupiah';
    }

    // ─────────────────────────────────────────────────────────────────
    // GENERATE NOMOR OTOMATIS
    // Format : ASY/{YY}/UPZ/{NNNN}
    // Contoh : ASY/26/UPZ/0001 → ASY/26/UPZ/0002 → ...
    // Reset  : tiap tahun baru mulai dari 0001 lagi
    // ─────────────────────────────────────────────────────────────────

    /**
     * Generate nomor urut baru (belum disimpan ke DB).
     * Panggil sebelum ZakatPenerimaan::create().
     *
     * @param  string $tahun  2 digit tahun (default: tahun sekarang, ex: "26")
     * @return string         ex: "ASY/26/UPZ/0001"
     */
    public static function generateNomor(string $tahun = ''): string
    {
        if ($tahun === '') {
            $tahun = date('y'); // 2 digit: 25, 26, 27, dst
        }

        $prefix = "ASY/{$tahun}/UPZ/";

        // Cari nomor terakhir di tahun yang sama
        $last = ZakatPenerimaan::where('nomor', 'like', $prefix . '%')
                    ->orderBy('nomor', 'desc')
                    ->value('nomor');

        $next = $last ? ((int) substr($last, -4)) + 1 : 1;

        return $prefix . str_pad($next, 4, '0', STR_PAD_LEFT);
        // Hasil: ASY/26/UPZ/0001, ASY/26/UPZ/0002, dst
    }
}