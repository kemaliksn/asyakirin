<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ZakatPenerimaan extends Model
{
    protected $fillable = [
        'nomor',
        'nama',
        'alamat',
        'telpon',
        'profesi',
        'jumlah_jiwa',
        'atas_nama',
        'items',
        'total_uang',
        'total_beras',
        'terbilang',
        'nama_amil',
        'tanggal',
        'tahun',
    ];

    // Cast JSON kolom otomatis jadi array PHP
    protected $casts = [
        'atas_nama'   => 'array',
        'items'       => 'array',
        'tanggal'     => 'date',
        'total_uang'  => 'integer',
        'total_beras' => 'float',
    ];
}