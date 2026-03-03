<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kelahiran extends Model
{
    protected $table = 'kelahiran';

    protected $fillable = [
        'nama_bayi', 'jenis_kelamin', 'tanggal_lahir', 'tempat_lahir',
        'jam_lahir', 'jenis_kelahiran', 'urutan_kelahiran',
        'penolong_kelahiran', 'tempat_dilahirkan',
        'berat_bayi', 'panjang_bayi',
        'nik_ayah', 'nama_ayah', 'nik_ibu', 'nama_ibu',
        'no_kk', 'keluarga_id',
        'penduduk_id', 'no_akta_lahir', 'tanggal_akta',
        'diinput_oleh',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
            'tanggal_akta' => 'date',
        ];
    }

    public function keluarga(): BelongsTo
    {
        return $this->belongsTo(Keluarga::class);
    }

    public function penduduk(): BelongsTo
    {
        return $this->belongsTo(Penduduk::class);
    }

    public function operator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diinput_oleh');
    }
}
