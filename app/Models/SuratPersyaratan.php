<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuratPersyaratan extends Model
{
    protected $table = 'surat_persyaratan';

    protected $fillable = ['surat_jenis_id', 'nama_syarat', 'keterangan', 'wajib', 'urutan'];

    protected function casts(): array
    {
        return ['wajib' => 'boolean'];
    }

    public function suratJenis(): BelongsTo
    {
        return $this->belongsTo(SuratJenis::class, 'surat_jenis_id');
    }
}
