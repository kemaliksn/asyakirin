<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanExport implements FromArray, WithHeadings, WithStyles
{
    protected $data;
    protected $tanggal;
    protected $namaKasir;

    public function __construct($data, $tanggal = null, $namaKasir = null)
    {
        $this->data = $data;
        $this->tanggal = $tanggal;
        $this->namaKasir = $namaKasir;
    }

    public function array(): array
    {
        $rows = [];
        $groupTotals = [];

        foreach ($this->data as $row) {
            // Ambil items per transaksi; fallback ke array kosong
            $items = is_array($row->items ?? null) ? $row->items : (json_decode($row->items ?? '[]', true) ?: []);

            // Jika tidak ada items, tulis satu baris agregat seperti sebelumnya
            if (empty($items)) {
                $rows[] = [
                    $row->nomor,
                    $row->nama,
                    $row->alamat,
                    $row->telpon,
                    $row->profesi,
                    $row->jumlah_jiwa,
                    $row->jenis_label ?? ($row->jenis ?? '-'),
                    $row->total_uang,
                    $row->total_beras,
                    $row->status,
                    optional($row->tanggal)->format('d M Y') ?? ($row->tanggal ?? ''),
                    $row->creator->name ?? ($row->nama_amil ?? 'Donatur'),
                ];

                // ringkasan total agregat tidak dimasukkan per-jenis di sini karena tidak ada rincian items
                continue;
            }

            // Tulis baris terpisah per item jenis
            foreach ($items as $it) {
                $jenis = (string) ($it['jenis'] ?? ($row->jenis ?? 'Lainnya'));
                $uang  = (int) ($it['uang']  ?? 0);
                $beras = (float) ($it['beras'] ?? 0);

                $rows[] = [
                    $row->nomor,
                    $row->nama,
                    $row->alamat,
                    $row->telpon,
                    $row->profesi,
                    $row->jumlah_jiwa,
                    $jenis,
                    $uang,
                    $beras,
                    $row->status,
                    optional($row->tanggal)->format('d M Y') ?? ($row->tanggal ?? ''),
                    $row->creator->name ?? ($row->nama_amil ?? 'Donatur'),
                ];

                // accumulate totals per jenis
                if (!isset($groupTotals[$jenis])) {
                    $groupTotals[$jenis] = ['uang' => 0, 'beras' => 0];
                }
                $groupTotals[$jenis]['uang']  += $uang;
                $groupTotals[$jenis]['beras'] += $beras;
            }
        }

        // add blank spacer row
        if (!empty($rows)) {
            $rows[] = array_fill(0, 12, '');
        }

        // add summary header
        $rows[] = [
            '', '', '', '', '', '', 'RINGKASAN PER JENIS', 'Total Uang (Rp)', 'Total Beras (Kg)', '', '', ''
        ];

        // append grouped totals rows
        foreach ($groupTotals as $jenis => $tot) {
            $rows[] = [
                '', '', '', '', '', '', $jenis, (int) $tot['uang'], (int) $tot['beras'], '', '', ''
            ];
        }

        // grand total row
        if (!empty($groupTotals)) {
            $grandUang = array_sum(array_column($groupTotals, 'uang'));
            $grandBeras = array_sum(array_column($groupTotals, 'beras'));
            $rows[] = ['', '', '', '', '', '', 'TOTAL SEMUA', (int) $grandUang, (int) $grandBeras, '', '', ''];
        }

        return $rows;
    }

    public function headings(): array
    {
        // Headings apply only to the detail section; the summary section is appended after rows
        return [
            'Nomor',
            'Nama Muzakki',
            'Alamat',
            'Telpon',
            'Profesi',
            'Jml Jiwa',
            'Jenis Zakat',
            'Total Uang (Rp)',
            'Total Beras (Kg)',
            'Status',
            'Tanggal',
            'Diinput Oleh',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Style header row
        $styles = [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '1a6b3c']],
            ],
        ];

        // Bold "RINGKASAN PER JENIS" and totals labels if present
        // Find the last row index
        $highestRow = $sheet->getHighestRow();
        for ($r = 2; $r <= $highestRow; $r++) {
            $cellVal = (string) $sheet->getCell("G{$r}")->getValue(); // column G holds the label we put
            if ($cellVal === 'RINGKASAN PER JENIS' || $cellVal === 'TOTAL SEMUA') {
                $styles[$r] = [
                    'font' => ['bold' => true],
                ];
            }
        }

        return $styles;
    }
}
