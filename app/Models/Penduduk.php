<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Penduduk extends Model
{
    protected $table = 'penduduk';

    protected $fillable = [
        'keluarga_id', 'nik', 'nama', 'tempat_lahir', 'tanggal_lahir',
        'jenis_kelamin', 'no_kk',
        'status_hubungan_keluarga', 'agama', 'kewarganegaraan', 'negara_asal',
        'status_perkawinan', 'tanggal_perkawinan', 'nik_pasangan',
        'pendidikan_dalam_kk', 'pendidikan_ditamatkan',
        'pekerjaan', 'pekerjaan_detail',
        'wilayah_rt_id', 'alamat_lengkap',
        'golongan_darah', 'tinggi_badan', 'berat_badan', 'cacat', 'jenis_cacat',
        'ayah_nama', 'ayah_nik', 'ibu_nama', 'ibu_nik',
        'no_akta_lahir', 'no_akta_perkawinan', 'no_akta_cerai',
        'no_paspor', 'tanggal_akhir_paspor', 'no_kitas_kitap',
        'no_bpjs_kesehatan', 'no_bpjs_ketenagakerjaan', 'penerima_bantuan',
        'status', 'tanggal_masuk', 'asal_daerah', 'foto',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
            'tanggal_perkawinan' => 'date',
            'tanggal_akhir_paspor' => 'date',
            'tanggal_masuk' => 'date',
            'cacat' => 'boolean',
            'penerima_bantuan' => 'boolean',
        ];
    }

    public function keluarga(): BelongsTo
    {
        return $this->belongsTo(Keluarga::class, 'keluarga_id');
    }

    public function wilayahRt(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class, 'wilayah_rt_id');
    }

    public function getUmurAttribute(): int
    {
        return $this->tanggal_lahir ? $this->tanggal_lahir->age : 0;
    }

    public function dokumen(): HasMany
    {
        return $this->hasMany(DokumenPenduduk::class);
    }

    public function mutasi(): HasMany
    {
        return $this->hasMany(PendudukMutasi::class);
    }
}
