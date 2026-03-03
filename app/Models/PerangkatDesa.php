<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerangkatDesa extends Model
{
    protected $table = 'perangkat_desa';

    protected $fillable = [
        'nama', 'nip', 'nik', 'jabatan', 'foto',
        'periode_mulai', 'periode_selesai',
        'telepon', 'email', 'alamat',
        'aktif', 'tampil_web', 'urutan',
    ];

    protected function casts(): array
    {
        return [
            'aktif' => 'boolean',
            'tampil_web' => 'boolean',
            'periode_mulai' => 'date',
            'periode_selesai' => 'date',
        ];
    }
}
