<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use App\Models\Admin;

class ZakatPenerimaan extends Model
{
    protected $table = 'zakat_penerimaans';

    protected $fillable = [
        'nomor',
        'nama',
        'created_by',
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
        'daily_sequence',
        'tanggal',
        'status',
        'tahun',
        'bukti',
        'bank',
    ];

    protected static function booted(): void
    {
        static::deleting(function (self $zakat): void {
            $guard = Auth::guard('admin')->check()
                ? 'admin'
                : (Auth::guard('web')->check() ? 'web' : null);

            $user = $guard ? Auth::guard($guard)->user() : null;

            ZakatPenerimaanDeletion::create([
                'zakat_penerimaan_id' => $zakat->id,
                'nomor' => $zakat->nomor,
                'deleted_data' => $zakat->toArray(),
                'deleted_by_guard' => $guard,
                'deleted_by_id' => $user?->id,
                'deleted_by_name' => $user?->name,
                'deleted_by_role' => $user?->role,
                'deleted_at' => now(),
            ]);
        });
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function deletionLogs()
    {
        return $this->hasMany(ZakatPenerimaanDeletion::class, 'zakat_penerimaan_id');
    }

    public function isInputByPengurus(): bool
    {
        return $this->created_by !== null;
    }
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
