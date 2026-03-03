<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebTeksBerjalan extends Model
{
    protected $table = 'web_teks_berjalan';

    protected $fillable = [
        'teks',
        'warna_teks',
        'warna_bg',
        'tanggal_mulai',
        'tanggal_selesai',
        'aktif',
        'urutan',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'aktif' => 'boolean',
        'urutan' => 'integer',
    ];

    public function scopeAktif($query)
    {
        return $query->where('aktif', true)
            ->where(function ($q) {
                $q->whereNull('tanggal_mulai')
                    ->orWhere('tanggal_mulai', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('tanggal_selesai')
                    ->orWhere('tanggal_selesai', '>=', now());
            })
            ->orderBy('urutan');
    }
}
