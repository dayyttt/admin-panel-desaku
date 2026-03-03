<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenTtd extends Model
{
    protected $table = 'dokumen_ttd';

    protected $fillable = ['nama', 'jabatan', 'ttd_path', 'stempel_path', 'aktif', 'default'];

    protected function casts(): array
    {
        return [
            'aktif' => 'boolean',
            'default' => 'boolean',
        ];
    }
}
