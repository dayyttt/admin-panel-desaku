<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BantuanPenerima extends Model
{
    protected $table = 'bantuan_penerima';

    protected $fillable = [
        'program_id',
        'penduduk_id',
        'nik',
        'nama',
        'tahun',
        'periode',
        'nominal',
        'status',
        'tanggal_diterima',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'tahun' => 'integer',
            'periode' => 'integer',
            'nominal' => 'decimal:2',
            'tanggal_diterima' => 'date',
        ];
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(BantuanProgram::class, 'program_id');
    }

    public function penduduk(): BelongsTo
    {
        return $this->belongsTo(Penduduk::class);
    }
}
