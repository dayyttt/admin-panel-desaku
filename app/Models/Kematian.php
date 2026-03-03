<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kematian extends Model
{
    protected $table = 'kematian';

    protected $fillable = [
        'penduduk_id', 'nik', 'nama',
        'tanggal_kematian', 'jam_kematian',
        'tempat_kematian', 'penyebab_kematian', 'jenis_kematian',
        'nama_pelapor', 'nik_pelapor', 'hubungan_pelapor',
        'no_akta_kematian', 'tanggal_akta',
        'diinput_oleh',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_kematian' => 'date',
            'tanggal_akta' => 'date',
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
}
