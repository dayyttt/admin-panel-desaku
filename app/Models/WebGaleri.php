<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebGaleri extends Model
{
    protected $table = 'web_galeri';

    protected $fillable = [
        'judul',
        'deskripsi',
        'tipe',
        'file_path',
        'url_video',
        'thumbnail',
        'tanggal_kegiatan',
        'lokasi_kegiatan',
        'publish',
        'urutan',
    ];

    protected $casts = [
        'publish' => 'boolean',
        'tanggal_kegiatan' => 'date',
        'urutan' => 'integer',
    ];

    public function scopePublished($query)
    {
        return $query->where('publish', true);
    }

    public function scopeTipe($query, $tipe)
    {
        return $query->where('tipe', $tipe);
    }
}
