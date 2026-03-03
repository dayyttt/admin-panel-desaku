<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Lapak extends Model
{
    protected $table = 'lapak';

    protected $fillable = [
        'penduduk_id',
        'nama_usaha',
        'slug',
        'kategori',
        'deskripsi',
        'nama_pemilik',
        'nik_pemilik',
        'alamat',
        'telepon',
        'whatsapp',
        'foto_usaha',
        'foto_lainnya',
        'latitude',
        'longitude',
        'publish',
        'aktif',
    ];

    protected $casts = [
        'foto_lainnya' => 'array',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'publish' => 'boolean',
        'aktif' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($lapak) {
            if (empty($lapak->slug)) {
                $lapak->slug = Str::slug($lapak->nama_usaha);
            }
        });
    }

    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class);
    }

    public function scopePublished($query)
    {
        return $query->where('publish', true)->where('aktif', true);
    }

    public function scopeKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }
}
