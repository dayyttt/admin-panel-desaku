<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Keluarga extends Model
{
    use SoftDeletes;

    protected $table = 'keluarga';

    protected $fillable = [
        'no_kk', 'nama_kepala_keluarga', 'wilayah_rt_id',
        'alamat', 'kode_pos', 'status', 'tanggal_buat_kk',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_buat_kk' => 'date',
        ];
    }

    public function anggota(): HasMany
    {
        return $this->hasMany(Penduduk::class, 'keluarga_id');
    }

    public function wilayahRt(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class, 'wilayah_rt_id');
    }

    public function getJumlahAnggotaAttribute(): int
    {
        return $this->anggota()->count();
    }
}
