<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BantuanProgram extends Model
{
    protected $table = 'bantuan_program';

    protected $fillable = [
        'nama',
        'singkatan',
        'deskripsi',
        'sumber_dana',
        'penyelenggara',
        'jenis_bantuan',
        'nominal_per_penerima',
        'satuan_nominal',
        'aktif',
    ];

    protected function casts(): array
    {
        return [
            'nominal_per_penerima' => 'decimal:2',
            'aktif' => 'boolean',
        ];
    }

    public function penerima(): HasMany
    {
        return $this->hasMany(BantuanPenerima::class, 'program_id');
    }

    public function penerimaAktif(): HasMany
    {
        return $this->hasMany(BantuanPenerima::class, 'program_id')
            ->where('status', 'aktif');
    }
}
