<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PembangunanKegiatan extends Model
{
    protected $table = 'pembangunan_kegiatan';

    protected $fillable = [
        'rkp_id',
        'apbdes_bidang_id',
        'nama',
        'deskripsi',
        'lokasi',
        'panjang',
        'lebar',
        'satuan',
        'anggaran',
        'realisasi',
        'progres_fisik',
        'tanggal_mulai',
        'tanggal_selesai_rencana',
        'tanggal_selesai_aktual',
        'kontraktor',
        'status',
        'foto_progres',
    ];

    protected function casts(): array
    {
        return [
            'panjang' => 'decimal:2',
            'lebar' => 'decimal:2',
            'anggaran' => 'decimal:2',
            'realisasi' => 'decimal:2',
            'progres_fisik' => 'integer',
            'tanggal_mulai' => 'date',
            'tanggal_selesai_rencana' => 'date',
            'tanggal_selesai_aktual' => 'date',
            'foto_progres' => 'json',
        ];
    }

    public function rkp(): BelongsTo
    {
        return $this->belongsTo(PembangunanRkp::class, 'rkp_id');
    }

    public function apbdesBidang(): BelongsTo
    {
        return $this->belongsTo(ApbdesBidang::class, 'apbdes_bidang_id');
    }

    public function inventaris(): HasMany
    {
        return $this->hasMany(PembangunanInventaris::class, 'kegiatan_id');
    }
}
