<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class SuratArsip extends Model
{
    protected $table = 'surat_arsip';

    protected $fillable = [
        'surat_jenis_id', 'penduduk_id', 'nik_pemohon', 'nama_pemohon',
        'nomor_surat', 'tanggal_surat', 'keperluan',
        'data_surat', 'file_pdf_path', 'qr_code',
        'ttd_id', 'dibuat_oleh', 'permohonan_id',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_surat' => 'date',
            'data_surat' => 'json',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function ($arsip) {
            if (empty($arsip->qr_code)) {
                $arsip->qr_code = Str::upper(Str::random(12));
            }
        });
    }

    public function suratJenis(): BelongsTo
    {
        return $this->belongsTo(SuratJenis::class, 'surat_jenis_id');
    }

    public function penduduk(): BelongsTo
    {
        return $this->belongsTo(Penduduk::class);
    }

    public function ttd(): BelongsTo
    {
        return $this->belongsTo(DokumenTtd::class, 'ttd_id');
    }

    public function operator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    public function permohonan(): BelongsTo
    {
        return $this->belongsTo(SuratPermohonan::class, 'permohonan_id');
    }
}
