<?php

namespace Database\Seeders;

use App\Models\Kelahiran;
use App\Models\Keluarga;
use App\Models\Penduduk;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class KelahiranSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil keluarga yang sudah ada
        $keluarga = Keluarga::with(['anggota' => function ($q) {
            $q->where('jenis_kelamin', 'L')
              ->where('status_perkawinan', 'kawin');
        }])->limit(3)->get();

        $kelahiran = [];
        $counter = 1;

        foreach ($keluarga as $kk) {
            $ayah = $kk->anggota->where('jenis_kelamin', 'L')->first();
            if (!$ayah) continue;

            $ibu = $kk->anggota->where('jenis_kelamin', 'P')
                                ->where('status_perkawinan', 'kawin')
                                ->first();

            // Data kelahiran bayi
            $tanggalLahir = Carbon::now()->subMonths(rand(1, 6));
            
            $kelahiran[] = [
                'nama_bayi' => $counter % 2 == 0 ? 'Siti Aisyah' : 'Muhammad Rizki',
                'jenis_kelamin' => $counter % 2 == 0 ? 'P' : 'L',
                'tanggal_lahir' => $tanggalLahir->format('Y-m-d'),
                'tempat_lahir' => 'Masohi',
                'jam_lahir' => sprintf('%02d:%02d:00', rand(0, 23), rand(0, 59)),
                'jenis_kelahiran' => 'tunggal',
                'urutan_kelahiran' => rand(1, 3),
                'penolong_kelahiran' => ['bidan', 'dokter'][rand(0, 1)],
                'tempat_dilahirkan' => ['Puskesmas Lesane', 'RSUD Masohi', 'Rumah'][rand(0, 2)],
                'berat_bayi' => rand(2500, 4000),
                'panjang_bayi' => rand(45, 55),
                'nik_ayah' => $ayah->nik,
                'nama_ayah' => $ayah->nama,
                'nik_ibu' => $ibu ? $ibu->nik : null,
                'nama_ibu' => $ibu ? $ibu->nama : 'Ibu ' . $ayah->nama,
                'no_kk' => $kk->no_kk,
                'keluarga_id' => $kk->id,
                'penduduk_id' => null,
                'no_akta_lahir' => '5302-LT-' . date('d') . date('m') . date('Y') . '-' . str_pad($counter, 4, '0', STR_PAD_LEFT),
                'tanggal_akta' => $tanggalLahir->addDays(rand(7, 30))->format('Y-m-d'),
                'diinput_oleh' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $counter++;
        }

        Kelahiran::insert($kelahiran);
        
        $this->command->info('✅ Berhasil membuat ' . count($kelahiran) . ' data kelahiran');
    }
}
