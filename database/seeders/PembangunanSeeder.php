<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PembangunanRkp;
use App\Models\PembangunanKegiatan;
use App\Models\PembangunanInventaris;
use App\Models\KaderMasyarakat;
use App\Models\Penduduk;

class PembangunanSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Seeding Pembangunan...');

        $tahun = now()->year;

        // 1. RKP Desa
        $rkp1 = PembangunanRkp::create([
            'tahun' => $tahun,
            'nama_kegiatan' => 'Pembangunan Jalan Desa',
            'bidang' => 'Infrastruktur',
            'lokasi' => 'Dusun Lesane Utara',
            'volume' => 500,
            'satuan_volume' => 'meter',
            'anggaran' => 150000000,
            'sumber_dana' => 'Dana Desa',
            'prioritas' => 'tinggi',
            'status' => 'disetujui',
            'keterangan' => 'Pembangunan jalan cor beton untuk akses desa',
        ]);

        $rkp2 = PembangunanRkp::create([
            'tahun' => $tahun,
            'nama_kegiatan' => 'Renovasi Balai Desa',
            'bidang' => 'Pemerintahan',
            'lokasi' => 'Kantor Desa Lesane',
            'volume' => 1,
            'satuan_volume' => 'unit',
            'anggaran' => 75000000,
            'sumber_dana' => 'APBDes',
            'prioritas' => 'sedang',
            'status' => 'berjalan',
            'keterangan' => 'Renovasi gedung balai desa',
        ]);

        $rkp3 = PembangunanRkp::create([
            'tahun' => $tahun,
            'nama_kegiatan' => 'Pembangunan Posyandu',
            'bidang' => 'Kesehatan',
            'lokasi' => 'Dusun Lesane Selatan',
            'volume' => 1,
            'satuan_volume' => 'unit',
            'anggaran' => 50000000,
            'sumber_dana' => 'APBD Kabupaten',
            'prioritas' => 'tinggi',
            'status' => 'rencana',
            'keterangan' => 'Pembangunan gedung posyandu baru',
        ]);

        $this->command->info('✓ 3 RKP Desa created');

        // 2. Kegiatan Pembangunan
        $kegiatan1 = PembangunanKegiatan::create([
            'rkp_id' => $rkp1->id,
            'nama' => 'Pengecoran Jalan Desa Fase 1',
            'deskripsi' => 'Pengecoran jalan sepanjang 250 meter dari pertigaan hingga jembatan',
            'lokasi' => 'Dusun Lesane Utara, RT 001/RW 001',
            'panjang' => 250,
            'lebar' => 3.5,
            'satuan' => 'meter',
            'anggaran' => 75000000,
            'realisasi' => 45000000,
            'progres_fisik' => 60,
            'tanggal_mulai' => now()->subMonths(2),
            'tanggal_selesai_rencana' => now()->addMonth(),
            'kontraktor' => 'CV Karya Mandiri',
            'status' => 'berjalan',
            'foto_progres' => json_encode([
                'progres_20.jpg',
                'progres_40.jpg',
                'progres_60.jpg',
            ]),
        ]);

        $kegiatan2 = PembangunanKegiatan::create([
            'rkp_id' => $rkp1->id,
            'nama' => 'Pengecoran Jalan Desa Fase 2',
            'deskripsi' => 'Pengecoran jalan sepanjang 250 meter dari jembatan hingga batas desa',
            'lokasi' => 'Dusun Lesane Utara, RT 002/RW 001',
            'panjang' => 250,
            'lebar' => 3.5,
            'satuan' => 'meter',
            'anggaran' => 75000000,
            'realisasi' => 0,
            'progres_fisik' => 0,
            'tanggal_mulai' => now()->addMonth(),
            'tanggal_selesai_rencana' => now()->addMonths(3),
            'kontraktor' => 'CV Karya Mandiri',
            'status' => 'perencanaan',
        ]);

        $kegiatan3 = PembangunanKegiatan::create([
            'rkp_id' => $rkp2->id,
            'nama' => 'Renovasi Balai Desa',
            'deskripsi' => 'Perbaikan atap, cat, dan lantai balai desa',
            'lokasi' => 'Kantor Desa Lesane',
            'anggaran' => 75000000,
            'realisasi' => 30000000,
            'progres_fisik' => 40,
            'tanggal_mulai' => now()->subMonth(),
            'tanggal_selesai_rencana' => now()->addMonths(2),
            'kontraktor' => 'Toko Bangunan Sejahtera',
            'status' => 'berjalan',
            'foto_progres' => json_encode([
                'renovasi_before.jpg',
                'renovasi_progress.jpg',
            ]),
        ]);

        $this->command->info('✓ 3 Kegiatan Pembangunan created');

        // 3. Inventaris Hasil Pembangunan
        PembangunanInventaris::create([
            'kegiatan_id' => $kegiatan1->id,
            'nama' => 'Jalan Cor Beton Dusun Lesane Utara',
            'deskripsi' => 'Jalan cor beton sepanjang 250 meter, lebar 3.5 meter',
            'lokasi' => 'Dusun Lesane Utara',
            'tanggal_serah_terima' => null, // Belum selesai
            'penerima' => 'Pemerintah Desa Lesane',
            'kondisi' => 'baik',
            'nilai' => 75000000,
            'keterangan' => 'Masih dalam proses pembangunan',
        ]);

        $this->command->info('✓ 1 Inventaris Hasil Pembangunan created');

        // 4. Kader Masyarakat
        $pendudukList = Penduduk::limit(10)->get();

        if ($pendudukList->isEmpty()) {
            $this->command->warn('⚠ Tidak ada data penduduk untuk kader.');
        } else {
            $kaderCount = 0;

            // Kader Posyandu
            foreach ($pendudukList->take(3) as $penduduk) {
                KaderMasyarakat::create([
                    'penduduk_id' => $penduduk->id,
                    'nama' => $penduduk->nama,
                    'nik' => $penduduk->nik,
                    'jenis_kader' => 'posyandu',
                    'wilayah' => 'Dusun Lesane',
                    'tanggal_bergabung' => now()->subYears(rand(1, 5)),
                    'aktif' => true,
                    'keterangan' => 'Kader Posyandu aktif',
                ]);
                $kaderCount++;
            }

            // Kader PKK
            foreach ($pendudukList->skip(3)->take(3) as $penduduk) {
                KaderMasyarakat::create([
                    'penduduk_id' => $penduduk->id,
                    'nama' => $penduduk->nama,
                    'nik' => $penduduk->nik,
                    'jenis_kader' => 'pkk',
                    'wilayah' => 'Desa Lesane',
                    'tanggal_bergabung' => now()->subYears(rand(1, 3)),
                    'aktif' => true,
                    'keterangan' => 'Pengurus PKK Desa',
                ]);
                $kaderCount++;
            }

            // Kader PAUD
            foreach ($pendudukList->skip(6)->take(2) as $penduduk) {
                KaderMasyarakat::create([
                    'penduduk_id' => $penduduk->id,
                    'nama' => $penduduk->nama,
                    'nik' => $penduduk->nik,
                    'jenis_kader' => 'paud',
                    'wilayah' => 'Desa Lesane',
                    'tanggal_bergabung' => now()->subYears(rand(1, 4)),
                    'aktif' => true,
                    'sertifikat' => 'Sertifikat Pendidik PAUD',
                    'keterangan' => 'Guru PAUD',
                ]);
                $kaderCount++;
            }

            // Kader Karang Taruna
            foreach ($pendudukList->skip(8)->take(2) as $penduduk) {
                KaderMasyarakat::create([
                    'penduduk_id' => $penduduk->id,
                    'nama' => $penduduk->nama,
                    'nik' => $penduduk->nik,
                    'jenis_kader' => 'karang_taruna',
                    'wilayah' => 'Desa Lesane',
                    'tanggal_bergabung' => now()->subYears(rand(1, 2)),
                    'aktif' => true,
                    'keterangan' => 'Pengurus Karang Taruna',
                ]);
                $kaderCount++;
            }

            $this->command->info("✓ {$kaderCount} Kader Masyarakat created");
        }

        $this->command->info('✅ Pembangunan seeding completed!');
    }
}
