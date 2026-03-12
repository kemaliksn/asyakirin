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
    protected $jenisColumns;

    public function __construct($data, $tanggal = null, $namaKasir = null)
    {
        $this->data = $data;
        $this->tanggal = $tanggal;
        $this->namaKasir = $namaKasir;

        // Scan data untuk menentukan kolom mana yang muncul
        $this->jenisColumns = $this->detectJenisColumns($data);
    }

    private function detectJenisColumns($data)
    {
        $jenisFound = [];

        foreach ($data as $row) {
            $items = is_array($row->items ?? null) ? $row->items : (json_decode($row->items ?? '[]', true) ?: []);

            foreach ($items as $it) {
                $jenis = strtolower(trim($it['jenis'] ?? ''));
                $uang = (int) ($it['uang'] ?? 0);
                $beras = (float) ($it['beras'] ?? 0);

                if ($uang > 0 || $beras > 0) {
                    // Mapping jenis ke label
                    $label = '';
                    switch ($jenis) {
                        case 'zakat fitrah':
                            $label = 'Zakat Fitrah';
                            break;
                        case 'zakat maal':
                            $label = 'Zakat Maal';
                            break;
                        case 'Infaq - Shodaqoh':
                        case 'infaq - shodaqoh':
                        case 'Infaq':
                        case 'Shodaqoh':
                        case 'infaq':
                        case 'shodaqoh':
                            $label = 'Infaq Shodaqoh';
                            break;
                        case 'yatim':
                            $label = 'Yatim';
                            break;
                        case 'fidyah':
                            $label = 'Fidyah';
                            break;
                    }
                    if ($label && !in_array($label, $jenisFound)) {
                        $jenisFound[] = $label;
                    }
                }
            }
        }

        return $jenisFound;
    }

    public function array(): array
    {
        $rows = [];
        $groupTotals = [];

        // Inisialisasi total per jenis yang ditemukan
        foreach ($this->jenisColumns as $jenis) {
            $groupTotals[$jenis] = ['uang' => 0, 'beras' => 0];
        }

        foreach ($this->data as $row) {
            // Ambil items per transaksi
            $items = is_array($row->items ?? null) ? $row->items : (json_decode($row->items ?? '[]', true) ?: []);

            // Inisialisasi nilai per jenis yang ditemukan
            $itemValues = [];
            foreach ($this->jenisColumns as $jenis) {
                $itemValues[$jenis] = ['uang' => 0, 'beras' => 0];
            }

            // Format nomor telepon agar tidak rusak di Excel (tangani +62)
            $telpon = $row->telpon;
            if (!empty($telpon) && (str_starts_with($telpon, '+62') || str_starts_with($telpon, '62'))) {
                $telpon = " " . $telpon; // Tambahkan apostrophe agar Excel baca sebagai teks
            }

            // Jika tidak ada items
            if (empty($items)) {
                $rowData = [
                    $row->nomor,
                    $row->nama,
                    $row->alamat,
                    $telpon,
                    $row->profesi,
                    $row->jumlah_jiwa,
                ];

                // Tambahkan kolom kosong untuk setiap jenis
                foreach ($this->jenisColumns as $jenis) {
                    $rowData[] = '';
                    $rowData[] = '';
                }

                $rowData[] = $row->total_uang;
                $rowData[] = $row->total_beras;
                
                // Metode Pembayaran
                $metode = $row->bank ?? '-';
                if (strtolower($metode) === 'qris') {
                    $metode = 'QRIS';
                } elseif (strtolower($metode) === 'cash') {
                    $metode = 'Cash';
                } elseif (strtolower($metode) === 'bsi' || strtolower($metode) === 'mandiri' || strtolower($metode) === 'bca' || strtolower($metode) === 'bni' || strtolower($metode) === 'bri' || strtolower($metode) === 'muamalat') {
                    $metode = 'TF';
                } elseif (empty($metode) || $metode === '-') {
                    $metode = '-';
                }
                $rowData[] = $metode;
                
                $rowData[] = $row->status;
                $rowData[] = optional($row->tanggal)->format('d M Y') ?? ($row->tanggal ?? '');
                $rowData[] = $row->creator->name ?? ($row->nama_amil ?? 'Donatur');

                $rows[] = $rowData;
                continue;
            }

            // Proses setiap item
            foreach ($items as $it) {
                $jenis = strtolower(trim($it['jenis'] ?? ''));
                $uang = (int) ($it['uang'] ?? 0);
                $beras = (float) ($it['beras'] ?? 0);

                $label = $this->getJenisLabel($jenis);
                if ($label && isset($itemValues[$label])) {
                    $itemValues[$label]['uang'] += $uang;
                    $itemValues[$label]['beras'] += $beras;
                    $groupTotals[$label]['uang'] += $uang;
                    $groupTotals[$label]['beras'] += $beras;
                }
            }

            // Build baris data
            $rowData = [
                $row->nomor,
                $row->nama,
                $row->alamat,
                $telpon,
                $row->profesi,
                $row->jumlah_jiwa,
            ];

            foreach ($this->jenisColumns as $jenis) {
                $uang = $itemValues[$jenis]['uang'];
                $beras = $itemValues[$jenis]['beras'];
                $rowData[] = $uang > 0 ? $uang : '';
                $rowData[] = $beras > 0 ? $beras : '';
            }

            $totalUang = array_sum(array_column($itemValues, 'uang'));
            $totalBeras = array_sum(array_column($itemValues, 'beras'));

            $rowData[] = $totalUang;
            $rowData[] = $totalBeras;
            
            // Metode Pembayaran - berdasarkan field bank
            $metode = $row->bank ?? '-';
            // Format: QRIS, Cash, atau Transfer (TF)
            if (strtolower($metode) === 'qris') {
                $metode = 'QRIS';
            } elseif (strtolower($metode) === 'cash') {
                $metode = 'Cash';
            } elseif (strtolower($metode) === 'bsi' || strtolower($metode) === 'mandiri' || strtolower($metode) === 'bca' || strtolower($metode) === 'bni' || strtolower($metode) === 'bri' || strtolower($metode) === 'muamalat') {
                $metode = 'TF';
            } elseif (empty($metode) || $metode === '-') {
                $metode = '-';
            }
            $rowData[] = $metode;
            
            $rowData[] = $row->status;
            $rowData[] = optional($row->tanggal)->format('d M Y') ?? ($row->tanggal ?? '');
            $rowData[] = $row->creator->name ?? ($row->nama_amil ?? 'Donatur');

            $rows[] = $rowData;
        }

        // Hitung jumlah kolom
        $baseColumns = 6; // nomor, nama, alamat, telpon, profesi, jumlah_jiwa
        $jenisColumns = count($this->jenisColumns) * 2; // uang & beras per jenis
        $totalColumns = $baseColumns + $jenisColumns + 6; // + total_uang, total_beras, metode, status, tanggal, input_by

        // add blank spacer row
        if (!empty($rows)) {
            $rows[] = array_fill(0, $totalColumns, '');
        }

        // add summary header
        $summaryRow = array_fill(0, $totalColumns, '');
        $summaryRow[4] = 'RINGKASAN PER JENIS';
        $rows[] = $summaryRow;

        // append grouped totals rows
        $colIndex = 6; // Mulai dari kolom setelah jumlah jiwa
        foreach ($this->jenisColumns as $jenis) {
            $tot = $groupTotals[$jenis];
            $uangVal = $tot['uang'] > 0 ? (int) $tot['uang'] : '';
            $berasVal = $tot['beras'] > 0 ? (int) $tot['beras'] : '';

            $row = array_fill(0, $totalColumns, '');
            $row[4] = $jenis;
            $row[$colIndex] = $uangVal;
            $row[$colIndex + 1] = $berasVal;
            $rows[] = $row;

            $colIndex += 2;
        }

        // grand total row
        $grandUang = array_sum(array_column($groupTotals, 'uang'));
        $grandBeras = array_sum(array_column($groupTotals, 'beras'));

        $grandRow = array_fill(0, $totalColumns, '');
        $grandRow[4] = 'TOTAL SEMUA';
        $grandRow[$baseColumns + $jenisColumns] = (int) $grandUang;
        $grandRow[$baseColumns + $jenisColumns + 1] = (int) $grandBeras;
        $rows[] = $grandRow;

        return $rows;
    }

    private function getJenisLabel($jenis)
    {
        switch ($jenis) {
            case 'zakat fitrah':
                return 'Zakat Fitrah';
            case 'zakat maal':
                return 'Zakat Maal';
            case 'infaq - shodaqoh':
            case 'infaq – shodaqoh':
            case 'infaq':
            case 'shodaqoh':
                return 'Infaq Shodaqoh';
            case 'yatim':
                return 'Yatim';
            case 'fidyah':
                return 'Fidyah';
            default:
                return null;
        }
    }

    public function headings(): array
    {
        $headings = [
            'Nomor',
            'Nama Muzakki',
            'Alamat',
            'Telpon',
            'Profesi',
            'Jml Jiwa',
        ];

        // Tambahkan heading untuk setiap jenis yang ditemukan
        foreach ($this->jenisColumns as $jenis) {
            $headings[] = $jenis . ' (Uang)';
            $headings[] = $jenis . ' (Beras)';
        }

        $headings[] = 'Total Uang (Rp)';
        $headings[] = 'Total Beras (Kg)';
        $headings[] = 'Metode Pembayaran';
        $headings[] = 'Status';
        $headings[] = 'Tanggal';
        $headings[] = 'Diinput Oleh';

        return $headings;
    }

    public function styles(Worksheet $sheet)
    {
        // Style header row
        $styles = [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '1a6b3c']],
                'alignment' => ['horizontal' => 'center', 'vertical' => 'middle'],
            ],
        ];

        // Bold "RINGKASAN PER JENIS" and totals labels if present
        $highestRow = $sheet->getHighestRow();
        for ($r = 2; $r <= $highestRow; $r++) {
            $cellVal = (string) $sheet->getCell("E{$r}")->getValue();
            if ($cellVal === 'RINGKASAN PER JENIS' || $cellVal === 'TOTAL SEMUA') {
                $styles[$r] = [
                    'font' => ['bold' => true],
                    'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'e8f5e9']],
                ];
            }
        }

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(12);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(8);

        // Dynamic column widths for jenis columns
        $col = 'G';
        foreach ($this->jenisColumns as $jenis) {
            $sheet->getColumnDimension($col)->setWidth(15);
            $col++;
            $sheet->getColumnDimension($col)->setWidth(15);
            $col++;
        }

        $sheet->getColumnDimension($col)->setWidth(15); $col++;
        $sheet->getColumnDimension($col)->setWidth(18); $col++; // Metode Pembayaran
        $sheet->getColumnDimension($col)->setWidth(10); $col++;
        $sheet->getColumnDimension($col)->setWidth(12); $col++;
        $sheet->getColumnDimension($col)->setWidth(15);

        return $styles;
    }
}
