<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class WebHalaman extends Model
{
    protected $table = 'web_halaman';

    protected $fillable = [
        'judul',
        'slug',
        'konten',
        'ikon',
        'publish',
        'tampil_menu',
        'urutan',
    ];

    protected $casts = [
        'publish' => 'boolean',
        'tampil_menu' => 'boolean',
        'urutan' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($halaman) {
            if (empty($halaman->slug)) {
                $halaman->slug = Str::slug($halaman->judul);
            }
        });
    }

    public function scopePublished($query)
    {
        return $query->where('publish', true);
    }

    public function scopeTampilMenu($query)
    {
        return $query->where('tampil_menu', true)->orderBy('urutan');
    }
}
