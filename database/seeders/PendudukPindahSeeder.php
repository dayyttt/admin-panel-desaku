<?php

namespace Database\Seeders;

use App\Models\PendudukPindah;
use App\Models\Penduduk;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PendudukPindahSeeder extends Seeder
{
    public function run(): void
    {
        $penduduk = Penduduk::limit(5)->get();
        
        $pindah = [];
        $counter = 1;

        // 3 pindah keluar
        for ($i = 0; $i < 3; $i++) {
            if (!isset($penduduk[$i])) break;
            
            $p = $penduduk[$i];
            $tanggalPindah = Carbon::now()->subMonths(rand(1, 6));
            
            $pindah[] = [
                'penduduk_id' => $p->id,
                'nik' => $p->nik,
                'nama' => $p->nama,
                'jenis' => 'pindah_keluar',
                'alamat_tujuan' => 'Jl. Merdeka No. ' . rand(1, 100) . ', Kota Ambon',
                'desa_tujuan' => 'Kelurahan Ahusen',
                'kecamatan_tujuan' => 'Sirimau',
                'kabupaten_tujuan' => 'Kota Ambon',
                'provinsi_tujuan' => 'Maluku',
                'alasan_pindah' => ['Pekerjaan', 'Pendidikan', 'Ikut Keluarga', 'Menikah'][rand(0, 3)],
                'klasifikasi_pindah' => 'antar_kabupaten',
                'alamat_asal' => null,
                'desa_asal' => null,
                'kecamatan_asal' => null,
                'kabupaten_asal' => null,
                'provinsi_asal' => null,
                'alasan_datang' => null,
                'no_surat_pindah' => '474.3/' . str_pad($counter, 3, '0', STR_PAD_LEFT) . '/PINDAH/' . date('Y'),
                'tanggal_pindah' => $tanggalPindah->format('Y-m-d'),
                'no_kk_baru' => null,
                'diinput_oleh' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            
            $counter++;
        }

        // 2 pindah masuk (datang)
        for ($i = 3; $i < 5; $i++) {
            if (!isset($penduduk[$i])) break;
            
            $p = $penduduk[$i];
            $tanggalPindah = Carbon::now()->subMonths(rand(1, 6));
            
            $pindah[] = [
                'penduduk_id' => $p->id,
                'nik' => $p->nik,
                'nama' => $p->nama,
                'jenis' => 'datang',
                'alamat_tujuan' => null,
                'desa_tujuan' => null,
                'kecamatan_tujuan' => null,
                'kabupaten_tujuan' => null,
                'provinsi_tujuan' => null,
                'alasan_pindah' => null,
                'klasifikasi_pindah' => null,
                'alamat_asal' => 'Jl. Pattimura No. ' . rand(1, 50) . ', Ambon',
                'desa_asal' => 'Kelurahan Batu Merah',
                'kecamatan_asal' => 'Sirimau',
                'kabupaten_asal' => 'Kota Ambon',
                'provinsi_asal' => 'Maluku',
                'alasan_datang' => ['Pekerjaan', 'Ikut Keluarga', 'Pulang Kampung'][rand(0, 2)],
                'no_surat_pindah' => '474.3/' . str_pad($counter, 3, '0', STR_PAD_LEFT) . '/DATANG/' . date('Y'),
                'tanggal_pindah' => $tanggalPindah->format('Y-m-d'),
                'no_kk_baru' => '5302' . rand(100000000000, 999999999999),
                'diinput_oleh' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            
            $counter++;
        }

        PendudukPindah::insert($pindah);
        
        $this->command->info('✅ Berhasil membuat ' . count($pindah) . ' data penduduk pindah (3 keluar, 2 masuk)');
    }
}
