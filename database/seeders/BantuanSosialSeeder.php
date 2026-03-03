<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BantuanProgram;
use App\Models\BantuanPenerima;
use App\Models\Penduduk;

class BantuanSosialSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Seeding Bantuan Sosial...');

        // 1. Program Keluarga Harapan (PKH)
        $pkh = BantuanProgram::create([
            'nama' => 'Program Keluarga Harapan',
            'singkatan' => 'PKH',
            'deskripsi' => 'Bantuan tunai bersyarat untuk keluarga miskin dengan ibu hamil, anak balita, dan anak sekolah',
            'sumber_dana' => 'APBN',
            'penyelenggara' => 'Kementerian Sosial',
            'jenis_bantuan' => 'uang_tunai',
            'nominal_per_penerima' => 3000000,
            'satuan_nominal' => 'per tahun',
            'aktif' => true,
        ]);

        // 2. Bantuan Langsung Tunai (BLT)
        $blt = BantuanProgram::create([
            'nama' => 'Bantuan Langsung Tunai Desa',
            'singkatan' => 'BLT Desa',
            'deskripsi' => 'Bantuan tunai langsung dari dana desa untuk keluarga miskin terdampak pandemi',
            'sumber_dana' => 'APBDes',
            'penyelenggara' => 'Pemerintah Desa',
            'jenis_bantuan' => 'uang_tunai',
            'nominal_per_penerima' => 600000,
            'satuan_nominal' => 'per bulan',
            'aktif' => true,
        ]);

        // 3. Bantuan Pangan Non Tunai (BPNT)
        $bpnt = BantuanProgram::create([
            'nama' => 'Bantuan Pangan Non Tunai',
            'singkatan' => 'BPNT',
            'deskripsi' => 'Bantuan pangan dalam bentuk non tunai melalui kartu elektronik',
            'sumber_dana' => 'APBN',
            'penyelenggara' => 'Kementerian Sosial',
            'jenis_bantuan' => 'sembako',
            'nominal_per_penerima' => 200000,
            'satuan_nominal' => 'per bulan',
            'aktif' => true,
        ]);

        // 4. Program Indonesia Pintar (PIP)
        $pip = BantuanProgram::create([
            'nama' => 'Program Indonesia Pintar',
            'singkatan' => 'PIP',
            'deskripsi' => 'Bantuan pendidikan untuk anak sekolah dari keluarga kurang mampu',
            'sumber_dana' => 'APBN',
            'penyelenggara' => 'Kemendikbud',
            'jenis_bantuan' => 'uang_tunai',
            'nominal_per_penerima' => 1000000,
            'satuan_nominal' => 'per tahun',
            'aktif' => true,
        ]);

        // 5. Bantuan Sembako
        $sembako = BantuanProgram::create([
            'nama' => 'Bantuan Sembako Desa',
            'singkatan' => 'Sembako',
            'deskripsi' => 'Bantuan sembako untuk warga kurang mampu',
            'sumber_dana' => 'APBDes',
            'penyelenggara' => 'Pemerintah Desa',
            'jenis_bantuan' => 'sembako',
            'nominal_per_penerima' => 150000,
            'satuan_nominal' => 'per paket',
            'aktif' => true,
        ]);

        $this->command->info('✓ 5 Program Bantuan created');

        // Ambil beberapa penduduk untuk dijadikan penerima
        $pendudukList = Penduduk::limit(20)->get();

        if ($pendudukList->isEmpty()) {
            $this->command->warn('⚠ Tidak ada data penduduk. Jalankan PendudukSeeder dulu.');
            return;
        }

        $tahun = now()->year;
        $penerimaCount = 0;

        // Tambah penerima untuk PKH (5 orang)
        foreach ($pendudukList->take(5) as $index => $penduduk) {
            BantuanPenerima::create([
                'program_id' => $pkh->id,
                'penduduk_id' => $penduduk->id,
                'nik' => $penduduk->nik,
                'nama' => $penduduk->nama,
                'tahun' => $tahun,
                'periode' => 1,
                'nominal' => 3000000,
                'status' => 'aktif',
                'tanggal_diterima' => now()->subMonths(rand(1, 6)),
                'keterangan' => 'Penerima PKH tahap 1',
            ]);
            $penerimaCount++;
        }

        // Tambah penerima untuk BLT Desa (8 orang)
        foreach ($pendudukList->skip(5)->take(8) as $penduduk) {
            BantuanPenerima::create([
                'program_id' => $blt->id,
                'penduduk_id' => $penduduk->id,
                'nik' => $penduduk->nik,
                'nama' => $penduduk->nama,
                'tahun' => $tahun,
                'periode' => now()->month,
                'nominal' => 600000,
                'status' => 'aktif',
                'tanggal_diterima' => now()->startOfMonth(),
                'keterangan' => 'BLT Desa bulan ' . now()->format('F'),
            ]);
            $penerimaCount++;
        }

        // Tambah penerima untuk BPNT (7 orang)
        foreach ($pendudukList->skip(13)->take(7) as $penduduk) {
            BantuanPenerima::create([
                'program_id' => $bpnt->id,
                'penduduk_id' => $penduduk->id,
                'nik' => $penduduk->nik,
                'nama' => $penduduk->nama,
                'tahun' => $tahun,
                'periode' => now()->month,
                'nominal' => 200000,
                'status' => 'aktif',
                'tanggal_diterima' => now()->startOfMonth(),
                'keterangan' => 'BPNT bulan ' . now()->format('F'),
            ]);
            $penerimaCount++;
        }

        $this->command->info("✓ {$penerimaCount} Penerima Bantuan created");
        $this->command->info('✅ Bantuan Sosial seeding completed!');
    }
}
