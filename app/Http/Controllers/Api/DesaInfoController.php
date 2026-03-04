<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DesaInfo;
use Illuminate\Http\Request;

class DesaInfoController extends Controller
{
    /**
     * Get info by key
     * For 'profil' key, merge data from DesaConfig
     */
    public function show($key)
    {
        // Jika request profil, ambil dari DesaConfig
        if ($key === 'profil') {
            $config = \App\Models\DesaConfig::first();
            
            if (!$config) {
                return response()->json([
                    'success' => false,
                    'message' => 'Konfigurasi desa belum diatur',
                ], 404);
            }

            // Get statistik data
            $totalPenduduk = \App\Models\Penduduk::count();
            $totalKK = \App\Models\Penduduk::distinct('no_kk')->count('no_kk');
            
            // Get geografi data for luas_wilayah and ketinggian
            $geografi = \App\Models\DesaInfo::where('key', 'geografi')->first();
            $luasWilayah = 0;
            $ketinggian = 0;
            
            if ($geografi && is_array($geografi->data)) {
                $luasWilayah = $geografi->data['luas_wilayah'] ?? 15.5; // default 15.5 km²
                $ketinggian = $geografi->data['ketinggian'] ?? 125; // default 125 mdpl
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'nama_desa' => $config->nama_desa,
                    'kode_desa' => $config->kode_desa,
                    'kecamatan' => $config->nama_kecamatan,
                    'kabupaten' => $config->nama_kabupaten,
                    'provinsi' => $config->nama_provinsi,
                    'kode_pos' => $config->kode_pos,
                    'alamat' => $config->alamat_kantor,
                    'telepon' => $config->telepon,
                    'email' => $config->email,
                    'website' => $config->website,
                    'logo' => $config->logo_path,
                    'visi' => $config->visi,
                    'misi' => $config->misi,
                    'sejarah' => $config->sejarah,
                    'nama_kepala_desa' => $config->nama_kepala_desa,
                    'foto_kepala_desa' => $config->foto_kepala_desa,
                    'latitude' => $config->latitude,
                    'longitude' => $config->longitude,
                    // Tambahan data statistik
                    'jumlah_penduduk' => $totalPenduduk,
                    'jumlah_kk' => $totalKK,
                    'luas_wilayah' => $luasWilayah,
                    'ketinggian' => $ketinggian,
                    'sambutan' => $config->sejarah, // Gunakan sejarah sebagai sambutan sementara
                ],
            ]);
        }

        // Untuk key lainnya, ambil dari DesaInfo
        $info = DesaInfo::where('key', $key)
            ->where('aktif', true)
            ->first();

        if (!$info) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $info->data,
        ]);
    }

    /**
     * Get all info
     * Include profil data from DesaConfig
     */
    public function index()
    {
        $infos = DesaInfo::where('aktif', true)->get();
        
        // Get profil data from DesaConfig
        $config = \App\Models\DesaConfig::first();
        
        $data = $infos->mapWithKeys(function ($info) {
            return [$info->key => $info->data];
        })->toArray();
        
        // Add profil data from DesaConfig
        if ($config) {
            $data['profil'] = [
                'nama_desa' => $config->nama_desa,
                'kode_desa' => $config->kode_desa,
                'kecamatan' => $config->nama_kecamatan,
                'kabupaten' => $config->nama_kabupaten,
                'provinsi' => $config->nama_provinsi,
                'kode_pos' => $config->kode_pos,
                'alamat' => $config->alamat_kantor,
                'telepon' => $config->telepon,
                'email' => $config->email,
                'website' => $config->website,
                'logo' => $config->logo_path,
                'visi' => $config->visi,
                'misi' => $config->misi,
                'sejarah' => $config->sejarah,
                'nama_kepala_desa' => $config->nama_kepala_desa,
                'foto_kepala_desa' => $config->foto_kepala_desa,
                'latitude' => $config->latitude,
                'longitude' => $config->longitude,
            ];
        }

        return response()->json([
            'data' => $data,
        ]);
    }
}
