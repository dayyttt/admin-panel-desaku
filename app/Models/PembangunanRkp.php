<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PembangunanRkp extends Model
{
    protected $table = 'pembangunan_rkp';

    protected $fillable = [
        'tahun',
        'nama_kegiatan',
        'bidang',
        'lokasi',
        'volume',
        'satuan_volume',
        'anggaran',
        'sumber_dana',
        'prioritas',
        'status',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'tahun' => 'integer',
            'volume' => 'decimal:2',
            'anggaran' => 'decimal:2',
        ];
    }

    public function kegiatan(): HasMany
    {
        return $this->hasMany(PembangunanKegiatan::class, 'rkp_id');
    }
}
