<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PendudukPindah extends Model
{
    protected $table = 'penduduk_pindah';

    protected $fillable = [
        'penduduk_id', 'nik', 'nama', 'jenis',
        'alamat_tujuan', 'desa_tujuan', 'kecamatan_tujuan',
        'kabupaten_tujuan', 'provinsi_tujuan', 'alasan_pindah',
        'klasifikasi_pindah',
        'alamat_asal', 'desa_asal', 'kecamatan_asal',
        'kabupaten_asal', 'provinsi_asal', 'alasan_datang',
        'no_surat_pindah', 'tanggal_pindah', 'no_kk_baru',
        'diinput_oleh',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_pindah' => 'date',
        ];
    }

    public function penduduk(): BelongsTo
    {
        return $this->belongsTo(Penduduk::class);
    }

    public function operator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diinput_oleh');
    }

    public function isPindahKeluar(): bool
    {
        return $this->jenis === 'pindah_keluar';
    }

    public function isDatang(): bool
    {
        return $this->jenis === 'datang';
    }
}
