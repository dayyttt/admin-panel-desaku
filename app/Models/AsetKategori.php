<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AsetKategori extends Model
{
    protected $table = 'aset_kategori';

    protected $fillable = [
        'nama',
        'kode',
        'keterangan',
    ];

    public function aset(): HasMany
    {
        return $this->hasMany(Aset::class, 'kategori_id');
    }

    public function asetAktif(): HasMany
    {
        return $this->hasMany(Aset::class, 'kategori_id')->where('aktif', true);
    }
}
