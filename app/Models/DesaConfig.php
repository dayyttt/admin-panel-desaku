<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DesaConfig extends Model
{
    protected $table = 'desa_config';

    protected $fillable = [
        'nama_desa', 'kode_desa', 'kode_pos',
        'nama_kecamatan', 'nama_kabupaten', 'nama_provinsi',
        'alamat_kantor', 'telepon', 'email', 'website',
        'latitude', 'longitude',
        'logo_path', 'foto_kantor_path', 'tema_warna', 'bg_web_path',
        'visi', 'misi', 'sejarah',
        'nama_kepala_desa', 'nip_kepala_desa', 'foto_kepala_desa',
        'ttd_kepala_desa', 'stempel_desa',
        'format_nomor_surat', 'kode_surat_desa',
        'tahun_apbdes_aktif',
        'wa_api_key', 'wa_api_url', 'wa_nomor_desa',
        'fcm_server_key',
        'smtp_host', 'smtp_port', 'smtp_user', 'smtp_pass', 'smtp_from_name',
        'facebook', 'instagram', 'youtube', 'twitter',
        'skor_idm_terakhir', 'status_idm', 'tahun_idm_terakhir',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'skor_idm_terakhir' => 'decimal:4',
        ];
    }
}
