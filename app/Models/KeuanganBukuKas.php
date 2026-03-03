<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KeuanganBukuKas extends Model
{
    protected $table = 'keuangan_buku_kas';

    protected $fillable = [
        'apbdes_id', 'transaksi_id', 'tanggal', 'uraian',
        'debit', 'kredit', 'saldo',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'debit' => 'decimal:2',
            'kredit' => 'decimal:2',
            'saldo' => 'decimal:2',
        ];
    }

    public function apbdes(): BelongsTo
    {
        return $this->belongsTo(Apbdes::class);
    }

    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(KeuanganTransaksi::class, 'transaksi_id');
    }
}
