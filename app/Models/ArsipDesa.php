<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArsipDesa extends Model
{
    protected $table = 'arsip_desa';

    protected $fillable = [
        'judul',
        'kode_arsip',
        'kategori',
        'tahun',
        'deskripsi',
        'file_path',
        'lokasi_fisik',
        'jumlah_halaman',
        'kondisi',
        'diupload_oleh',
    ];

    protected $casts = [
        'tahun' => 'integer',
        'jumlah_halaman' => 'integer',
    ];

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diupload_oleh');
    }
}
