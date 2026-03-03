<?php

namespace Database\Seeders;

use App\Models\Keluarga;
use App\Models\Penduduk;
use Illuminate\Database\Seeder;

class KeluargaSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil beberapa penduduk yang sudah ada untuk dijadikan kepala keluarga
        $penduduks = Penduduk::where('status', 'aktif')
            ->where('jenis_kelamin', 'L')
            ->whereIn('status_perkawinan', ['kawin', 'cerai_mati'])
            ->limit(10)
            ->get();

        if ($penduduks->isEmpty()) {
            $this->command->warn('⚠️ Tidak ada data penduduk. Jalankan PendudukSeeder terlebih dahulu.');
            return;
        }

        $keluargaData = [];
        $counter = 1;

        foreach ($penduduks as $penduduk) {
            $noKK = '8171' . str_pad($counter, 12, '0', STR_PAD_LEFT);
            
            $keluarga = Keluarga::create([
                'no_kk' => $noKK,
                'nama_kepala_keluarga' => $penduduk->nama,
                'wilayah_rt_id' => $penduduk->wilayah_rt_id,
                'alamat' => $penduduk->alamat_lengkap ?? 'Desa Lesane',
                'kode_pos' => '97513',
                'status' => 'aktif',
                'tanggal_buat_kk' => now()->subYears(rand(1, 10)),
            ]);

            // Update penduduk dengan keluarga_id dan no_kk
            $penduduk->update([
                'keluarga_id' => $keluarga->id,
                'no_kk' => $noKK,
                'status_hubungan_keluarga' => 'kepala_keluarga',
            ]);

            // Cari istri (jika ada penduduk perempuan dengan status kawin)
            $istri = Penduduk::where('status', 'aktif')
                ->where('jenis_kelamin', 'P')
                ->where('status_perkawinan', 'kawin')
                ->whereNull('keluarga_id')
                ->first();

            if ($istri) {
                $istri->update([
                    'keluarga_id' => $keluarga->id,
                    'no_kk' => $noKK,
                    'status_hubungan_keluarga' => 'istri',
                    'nik_pasangan' => $penduduk->nik,
                ]);

                // Update NIK pasangan kepala keluarga
                $penduduk->update([
                    'nik_pasangan' => $istri->nik,
                ]);
            }

            // Cari anak (penduduk muda yang belum punya keluarga)
            $anaks = Penduduk::where('status', 'aktif')
                ->whereNull('keluarga_id')
                ->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) < 18')
                ->limit(rand(1, 3))
                ->get();

            foreach ($anaks as $anak) {
                $anak->update([
                    'keluarga_id' => $keluarga->id,
                    'no_kk' => $noKK,
                    'status_hubungan_keluarga' => 'anak',
                    'ayah_nik' => $penduduk->nik,
                    'ayah_nama' => $penduduk->nama,
                    'ibu_nik' => $istri->nik ?? null,
                    'ibu_nama' => $istri->nama ?? null,
                ]);
            }

            $counter++;
        }

        $this->command->info('✅ Seeder Keluarga selesai: ' . $counter . ' KK dibuat');
    }
}
