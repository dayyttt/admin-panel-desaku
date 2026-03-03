<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KaderMasyarakat extends Model
{
    protected $table = 'kader_masyarakat';

    protected $fillable = [
        'penduduk_id',
        'nama',
        'nik',
        'jenis_kader',
        'wilayah',
        'tanggal_bergabung',
        'aktif',
        'sertifikat',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_bergabung' => 'date',
            'aktif' => 'boolean',
        ];
    }

    public function penduduk(): BelongsTo
    {
        return $this->belongsTo(Penduduk::class);
    }
}
