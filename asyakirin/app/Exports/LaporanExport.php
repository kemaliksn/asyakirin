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
        foreach ($this->data as $row) {
            $rows[] = [
                $row->nomor,
                $row->nama,
                $row->alamat,
                $row->telpon,
                $row->profesi,
                $row->jumlah_jiwa,
                $row->jenis,
                $row->total_uang,
                $row->total_beras,
                $row->status,
                $row->tanggal,
                $row->input_by,
            ];
        }
        return $rows;
    }

    public function headings(): array
    {
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
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '1a6b3c']],
            ],
        ];
    }
}
