<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DokumenPenduduk extends Model
{
    protected $table = 'dokumen_penduduk';

    protected $fillable = [
        'penduduk_id', 'jenis_dokumen', 'nama_dokumen',
        'file_path', 'nomor_dokumen',
        'tanggal_dokumen', 'masa_berlaku',
        'keterangan', 'diupload_oleh',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_dokumen' => 'date',
            'masa_berlaku' => 'date',
        ];
    }

    public function penduduk(): BelongsTo
    {
        return $this->belongsTo(Penduduk::class);
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diupload_oleh');
    }
}
