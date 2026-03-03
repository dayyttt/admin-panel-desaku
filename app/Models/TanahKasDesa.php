<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TanahKasDesa extends Model
{
    protected $table = 'tanah_kas_desa';

    protected $fillable = [
        'nama_bidang',
        'nomor_persil',
        'kelas_tanah',
        'luas',
        'lokasi',
        'latitude',
        'longitude',
        'status_tanah',
        'nomor_sertifikat',
        'tanggal_sertifikat',
        'penggunaan_tanah',
        'nilai_tanah',
        'keterangan',
        'foto',
    ];

    protected $casts = [
        'luas' => 'decimal:2',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'tanggal_sertifikat' => 'date',
        'nilai_tanah' => 'decimal:2',
    ];
}
