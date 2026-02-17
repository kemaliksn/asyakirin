<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ZakatPenerimaan extends Model
{
    protected $table = 'zakat_penerimaans';

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
        'status',
        'tahun',
    ];

    // Otomatis decode JSON saat diakses
    protected $casts = [
        'atas_nama' => 'array',
        'items'     => 'array',
        'tanggal'   => 'date',
    ];

    // ── Scope filter status ──
    public function scopeLunas($query)
    {
        return $query->where('status', 'Lunas');
    }

    public function scopeBelumLunas($query)
    {
        return $query->where('status', 'Belum Lunas');
    }

    // ── Badge CSS class untuk blade ──
    public function getBadgeClassAttribute(): string
    {
        return match($this->status) {
            'Lunas'       => 'lunas',
            'Belum Lunas' => 'pending',
            'Batal'       => 'batal',
            default       => 'pending',
        };
    }

    // ── Ambil daftar jenis dari JSON items ──
    public function getJenisLabelAttribute(): string
    {
        if (empty($this->items)) return '-';
        $jenisList = array_unique(array_column($this->items, 'jenis'));
        return implode(', ', $jenisList);
    }
}
