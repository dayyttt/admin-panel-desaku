<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Aset extends Model
{
    protected $table = 'aset';

    protected $fillable = [
        'kategori_id',
        'nama',
        'kode_inventaris',
        'tahun_perolehan',
        'cara_perolehan',
        'nilai_perolehan',
        'kondisi',
        'lokasi',
        'luas',
        'satuan',
        'volume',
        'foto',
        'keterangan',
        'aktif',
    ];

    protected $casts = [
        'tahun_perolehan' => 'integer',
        'nilai_perolehan' => 'decimal:2',
        'luas' => 'decimal:2',
        'volume' => 'decimal:2',
        'aktif' => 'boolean',
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(AsetKategori::class, 'kategori_id');
    }
}
