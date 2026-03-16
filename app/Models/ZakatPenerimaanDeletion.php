<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ZakatPenerimaanDeletion extends Model
{
    protected $table = 'zakat_penerimaan_deletions';

    public $timestamps = false;

    protected $fillable = [
        'zakat_penerimaan_id',
        'nomor',
        'deleted_data',
        'deleted_by_guard',
        'deleted_by_id',
        'deleted_by_name',
        'deleted_by_role',
        'deleted_at',
    ];

    protected $casts = [
        'deleted_data' => 'array',
        'deleted_at' => 'datetime',
    ];

    public function zakatPenerimaan()
    {
        return $this->belongsTo(ZakatPenerimaan::class, 'zakat_penerimaan_id');
    }
}
