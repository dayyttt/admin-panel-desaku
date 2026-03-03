<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class WebPotensi extends Model
{
    protected $table = 'web_potensi';

    protected $fillable = [
        'judul',
        'kategori',
        'deskripsi',
        'foto',
        'latitude',
        'longitude',
        'kontak',
        'publish',
        'urutan',
    ];

    protected $casts = [
        'foto' => 'array',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'publish' => 'boolean',
        'urutan' => 'integer',
    ];

    // Accessor untuk memastikan foto selalu array
    protected function foto(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => is_string($value) ? json_decode($value, true) : $value,
        );
    }

    public function scopePublished($query)
    {
        return $query->where('publish', true)->orderBy('urutan');
    }

    public function scopeKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }
}
