<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class WebArtikel extends Model
{
    protected $table = 'web_artikel';

    protected $fillable = [
        'judul',
        'slug',
        'kategori',
        'konten',
        'ringkasan',
        'thumbnail',
        'gambar_galeri',
        'publish',
        'published_at',
        'view_count',
        'dibuat_oleh',
    ];

    protected $casts = [
        'gambar_galeri' => 'array',
        'publish' => 'boolean',
        'published_at' => 'datetime',
        'view_count' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($artikel) {
            if (empty($artikel->slug)) {
                $artikel->slug = Str::slug($artikel->judul);
            }
            if (empty($artikel->dibuat_oleh)) {
                $artikel->dibuat_oleh = auth()->id();
            }
        });
    }

    public function penulis()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    public function scopePublished($query)
    {
        return $query->where('publish', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }
}
