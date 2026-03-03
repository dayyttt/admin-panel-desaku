<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApbdesRab extends Model
{
    protected $table = 'apbdes_rab';

    protected $fillable = [
        'bidang_id', 'uraian', 'volume', 'satuan',
        'harga_satuan', 'jumlah', 'keterangan', 'urutan',
    ];

    protected function casts(): array
    {
        return [
            'volume' => 'decimal:2',
            'harga_satuan' => 'decimal:2',
            'jumlah' => 'decimal:2',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function ($rab) {
            $rab->jumlah = $rab->volume * $rab->harga_satuan;
        });
    }

    public function bidang(): BelongsTo
    {
        return $this->belongsTo(ApbdesBidang::class, 'bidang_id');
    }
}
