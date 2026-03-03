<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PendudukMutasi extends Model
{
    protected $table = 'penduduk_mutasi';

    protected $fillable = [
        'penduduk_id', 'nik', 'jenis_mutasi',
        'data_sebelum', 'data_sesudah',
        'keterangan', 'diinput_oleh', 'tanggal_mutasi',
    ];

    protected function casts(): array
    {
        return [
            'data_sebelum' => 'json',
            'data_sesudah' => 'json',
            'tanggal_mutasi' => 'datetime',
        ];
    }

    public function penduduk(): BelongsTo
    {
        return $this->belongsTo(Penduduk::class);
    }

    public function operator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diinput_oleh');
    }
}
