<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PembangunanInventaris extends Model
{
    protected $table = 'pembangunan_inventaris';

    protected $fillable = [
        'kegiatan_id',
        'nama',
        'deskripsi',
        'lokasi',
        'tanggal_serah_terima',
        'penerima',
        'kondisi',
        'nilai',
        'foto',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_serah_terima' => 'date',
            'nilai' => 'decimal:2',
        ];
    }

    public function kegiatan(): BelongsTo
    {
        return $this->belongsTo(PembangunanKegiatan::class, 'kegiatan_id');
    }
}
