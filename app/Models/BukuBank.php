<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BukuBank extends Model
{
    protected $table = 'buku_bank';

    protected $fillable = [
        'apbdes_id', 'nama_bank', 'nomor_rekening', 'atas_nama',
        'tanggal', 'uraian', 'debit', 'kredit', 'saldo',
        'transaksi_id', 'sudah_rekonsiliasi',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'debit' => 'decimal:2',
            'kredit' => 'decimal:2',
            'saldo' => 'decimal:2',
            'sudah_rekonsiliasi' => 'boolean',
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
