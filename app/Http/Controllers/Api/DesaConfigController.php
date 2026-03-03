<?php

namespace App\Http\Controllers\Api;

use App\Models\DesaConfig;
use Illuminate\Http\JsonResponse;

class DesaConfigController
{
    public function index(): JsonResponse
    {
        $config = DesaConfig::first();

        if (!$config) {
            return response()->json(['message' => 'Konfigurasi desa belum diatur'], 404);
        }

        return response()->json([
            'data' => [
                'nama_desa' => $config->nama_desa,
                'kode_desa' => $config->kode_desa,
                'nama_kecamatan' => $config->nama_kecamatan,
                'nama_kabupaten' => $config->nama_kabupaten,
                'nama_provinsi' => $config->nama_provinsi,
                'kode_pos' => $config->kode_pos,
                'telepon' => $config->telepon,
                'email' => $config->email,
                'website' => $config->website,
                'alamat_kantor' => $config->alamat_kantor,
                'logo' => $config->logo ? asset('storage/' . $config->logo) : null,
                'sambutan_kades' => $config->sambutan_kades,
                'visi' => $config->visi,
                'misi' => $config->misi,
                'sejarah' => $config->sejarah,
                'luas_wilayah' => $config->luas_wilayah,
                'batas_utara' => $config->batas_utara,
                'batas_selatan' => $config->batas_selatan,
                'batas_timur' => $config->batas_timur,
                'batas_barat' => $config->batas_barat,
                'latitude' => $config->latitude,
                'longitude' => $config->longitude,
            ],
        ]);
    }
}
