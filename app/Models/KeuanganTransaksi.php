<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KeuanganTransaksi extends Model
{
    protected $table = 'keuangan_transaksi';

    protected $fillable = [
        'apbdes_id', 'bidang_id', 'no_bukti', 'tanggal', 'jenis',
        'uraian', 'jumlah', 'sumber_dana', 'penerima_pembayar',
        'rekening_tujuan', 'bukti_path', 'status',
        'catatan', 'alasan_tolak',
        'diinput_oleh', 'diverifikasi_oleh', 'diverifikasi_at',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'jumlah' => 'decimal:2',
            'diverifikasi_at' => 'datetime',
        ];
    }

    public function apbdes(): BelongsTo
    {
        return $this->belongsTo(Apbdes::class);
    }

    public function bidang(): BelongsTo
    {
        return $this->belongsTo(ApbdesBidang::class, 'bidang_id');
    }

    public function operator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diinput_oleh');
    }

    public function verifikator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diverifikasi_oleh');
    }
}
