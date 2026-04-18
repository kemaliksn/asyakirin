<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Admin;

class QurbanPenerimaan extends Model
{
    protected $table = 'qurban_penerimaans';

    protected $fillable = [
        'nomor',
        'nama',
        'created_by',
        'alamat',
        'telpon',
        'profesi',
        'items',
        'total_uang',
        'terbilang',
        'nama_amil',
        'daily_sequence',
        'tanggal',
        'status',
        'tahun',
        'bukti',
        'bank',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function isInputByPengurus(): bool
    {
        return $this->created_by !== null;
    }

    // Otomatis decode JSON saat diakses
    protected $casts = [
        'items'   => 'array',
        'tanggal' => 'date',
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
