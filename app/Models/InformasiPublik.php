<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InformasiPublik extends Model
{
    protected $table = 'informasi_publik';

    protected $fillable = [
        'judul',
        'kategori',
        'tahun',
        'deskripsi',
        'file_path',
        'url_eksternal',
        'aktif',
        'urutan',
        'diupload_oleh',
    ];

    protected $casts = [
        'tahun' => 'integer',
        'aktif' => 'boolean',
        'urutan' => 'integer',
    ];

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diupload_oleh');
    }
}
