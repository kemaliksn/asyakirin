<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class QurbanExport implements FromArray, WithHeadings, WithStyles
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        $rows = [];

        foreach ($this->data as $row) {
            $namaJiwa = is_array($row->nama_jiwa) ? implode(' | ', array_filter($row->nama_jiwa)) : '';
            $items = is_array($row->items) ? $row->items : (json_decode($row->items ?? '[]', true) ?: []);
            $jenisLabel = '';
            if (!empty($items)) {
                $jenisLabel = implode(', ', array_unique(array_column($items, 'jenis')));
            }

            $rows[] = [
                $row->nomor,
                $row->nama,
                $row->alamat,
                $row->telpon,
                $row->profesi,
                $namaJiwa,
                $row->catatan ?? '',
                $jenisLabel,
                $row->total_uang,
                $row->bank ?? '',
                $row->status,
                (optional($row->tanggal)->format('d M Y')) ?? ($row->tanggal ?? ''),
                $row->creator->name ?? ($row->nama_amil ?? 'Donatur'),
            ];
        }

        return $rows;
    }

    public function headings(): array
    {
        return [
            'No. Referensi',
            'Nama Pembayar',
            'Alamat',
            'Telpon',
            'Profesi',
            'Nama Jiwa',
            'Catatan',
            'Item Qurban',
            'Total Uang (Rp)',
            'Metode Pembayaran',
            'Status',
            'Tanggal',
            'Diinput Oleh',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '1A6B3C']],
                'alignment' => ['horizontal' => 'center', 'vertical' => 'middle'],
            ],
        ];
    }
}
