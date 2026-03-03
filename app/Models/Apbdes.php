<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Apbdes extends Model
{
    protected $table = 'apbdes';

    protected $fillable = [
        'tahun', 'nama', 'status',
        'total_pendapatan', 'total_belanja', 'total_pembiayaan', 'surplus_defisit',
        'keterangan', 'dibuat_oleh', 'disetujui_at', 'disetujui_oleh',
    ];

    protected function casts(): array
    {
        return [
            'total_pendapatan' => 'decimal:2',
            'total_belanja' => 'decimal:2',
            'total_pembiayaan' => 'decimal:2',
            'surplus_defisit' => 'decimal:2',
            'disetujui_at' => 'datetime',
        ];
    }

    public function bidang(): HasMany
    {
        return $this->hasMany(ApbdesBidang::class, 'apbdes_id');
    }

    public function transaksi(): HasMany
    {
        return $this->hasMany(KeuanganTransaksi::class, 'apbdes_id');
    }

    public function pembuat(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    /** Hitung ulang total dari bidang */
    public function hitungUlang(): void
    {
        $this->total_pendapatan = $this->bidang()->where('jenis', 'pendapatan')->where('level', 'bidang')->sum('anggaran');
        $this->total_belanja = $this->bidang()->where('jenis', 'belanja')->where('level', 'bidang')->sum('anggaran');
        $this->total_pembiayaan = $this->bidang()->where('jenis', 'pembiayaan')->where('level', 'bidang')->sum('anggaran');
        $this->surplus_defisit = $this->total_pendapatan - $this->total_belanja + $this->total_pembiayaan;
        $this->save();
    }
}
