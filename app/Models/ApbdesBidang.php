<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ApbdesBidang extends Model
{
    protected $table = 'apbdes_bidang';

    protected $fillable = [
        'apbdes_id', 'parent_id', 'level', 'kode', 'nama',
        'jenis', 'anggaran', 'realisasi', 'keterangan', 'urutan',
    ];

    protected function casts(): array
    {
        return [
            'anggaran' => 'decimal:2',
            'realisasi' => 'decimal:2',
        ];
    }

    public function apbdes(): BelongsTo
    {
        return $this->belongsTo(Apbdes::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function rab(): HasMany
    {
        return $this->hasMany(ApbdesRab::class, 'bidang_id');
    }

    public function getPersentaseRealisasiAttribute(): float
    {
        return $this->anggaran > 0 ? round(($this->realisasi / $this->anggaran) * 100, 1) : 0;
    }
}
