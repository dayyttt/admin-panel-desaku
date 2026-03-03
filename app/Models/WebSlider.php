<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebSlider extends Model
{
    protected $table = 'web_slider';

    protected $fillable = [
        'judul',
        'subjudul',
        'foto_path',
        'url_aksi',
        'label_tombol',
        'aktif',
        'urutan',
    ];

    protected $casts = [
        'aktif' => 'boolean',
        'urutan' => 'integer',
    ];

    public function scopeAktif($query)
    {
        return $query->where('aktif', true)->orderBy('urutan');
    }
}
