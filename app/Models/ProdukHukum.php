<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdukHukum extends Model
{
    protected $table = 'produk_hukum';

    protected $fillable = [
        'jenis',
        'nomor',
        'tahun',
        'judul',
        'tentang',
        'tanggal_ditetapkan',
        'tanggal_berlaku',
        'file_path',
        'tampil_publik',
        'status',
        'keterangan',
    ];

    protected $casts = [
        'tahun' => 'integer',
        'tanggal_ditetapkan' => 'date',
        'tanggal_berlaku' => 'date',
        'tampil_publik' => 'boolean',
    ];
}
