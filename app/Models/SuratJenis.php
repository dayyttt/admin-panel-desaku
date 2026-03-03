<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SuratJenis extends Model
{
    protected $table = 'surat_jenis';

    protected $fillable = [
        'kategori_id', 'nama', 'kode', 'singkatan', 'deskripsi',
        'template_path', 'variabel', 'field_tambahan',
        'format_nomor', 'nomor_terakhir', 'tahun_nomor',
        'perlu_ttd_kades', 'aktif_permohonan_online', 'aktif', 'urutan',
    ];

    protected function casts(): array
    {
        return [
            'variabel' => 'json',
            'field_tambahan' => 'json',
            'perlu_ttd_kades' => 'boolean',
            'aktif_permohonan_online' => 'boolean',
            'aktif' => 'boolean',
        ];
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(SuratKategori::class, 'kategori_id');
    }

    public function persyaratan(): HasMany
    {
        return $this->hasMany(SuratPersyaratan::class, 'surat_jenis_id');
    }

    public function arsip(): HasMany
    {
        return $this->hasMany(SuratArsip::class, 'surat_jenis_id');
    }

    /**
     * Generate nomor surat berikutnya
     */
    public function generateNomorSurat(): string
    {
        $tahunSekarang = (int) date('Y');

        if ($this->tahun_nomor !== $tahunSekarang) {
            $this->nomor_terakhir = 0;
            $this->tahun_nomor = $tahunSekarang;
        }

        $this->nomor_terakhir++;
        $this->save();

        $format = $this->format_nomor ?? '{nomor}/{kode}/{romawi}/{tahun}';
        $romawi = ['', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];

        return str_replace(
            ['{nomor}', '{kode}', '{romawi}', '{tahun}', '{singkatan}'],
            [
                str_pad($this->nomor_terakhir, 3, '0', STR_PAD_LEFT),
                $this->kode,
                $romawi[(int) date('m')],
                $tahunSekarang,
                $this->singkatan ?? $this->kode,
            ],
            $format
        );
    }
}
