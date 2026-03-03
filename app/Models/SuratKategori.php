<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SuratKategori extends Model
{
    protected $table = 'surat_kategori';

    protected $fillable = ['nama', 'kode', 'deskripsi', 'urutan', 'aktif'];

    protected function casts(): array
    {
        return ['aktif' => 'boolean'];
    }

    public function jenislist(): HasMany
    {
        return $this->hasMany(SuratJenis::class, 'kategori_id');
    }
}
