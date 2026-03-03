<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuratPermohonan extends Model
{
    protected $table = 'surat_permohonan';

    protected $fillable = [
        'surat_jenis_id', 'user_id', 'penduduk_id',
        'nik', 'nama', 'keperluan',
        'data_tambahan', 'dokumen_pendukung',
        'status', 'catatan_operator', 'alasan_tolak',
        'diproses_oleh', 'diproses_at', 'surat_arsip_id',
    ];

    protected function casts(): array
    {
        return [
            'data_tambahan' => 'json',
            'dokumen_pendukung' => 'json',
            'diproses_at' => 'datetime',
        ];
    }

    public function suratJenis(): BelongsTo
    {
        return $this->belongsTo(SuratJenis::class, 'surat_jenis_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function penduduk(): BelongsTo
    {
        return $this->belongsTo(Penduduk::class);
    }

    public function operator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diproses_oleh');
    }

    public function suratArsip(): BelongsTo
    {
        return $this->belongsTo(SuratArsip::class, 'surat_arsip_id');
    }
}
