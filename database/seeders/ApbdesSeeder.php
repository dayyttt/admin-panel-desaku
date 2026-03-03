<?php

namespace Database\Seeders;

use App\Models\Apbdes;
use App\Models\ApbdesBidang;
use Illuminate\Database\Seeder;

class ApbdesSeeder extends Seeder
{
    public function run(): void
    {
        // Create APBDes 2026
        $apbdes = Apbdes::create([
            'tahun' => 2026,
            'nama' => 'APBDes Tahun Anggaran 2026',
            'status' => 'aktif',
            'total_pendapatan' => 1500000000,
            'total_belanja' => 1450000000,
            'total_pembiayaan' => 0,
            'surplus_defisit' => 50000000,
            'keterangan' => 'APBDes Desa Lesane Tahun Anggaran 2026',
            'dibuat_oleh' => 1,
            'disetujui_at' => now()->subMonths(2),
            'disetujui_oleh' => 1,
        ]);

        // ========== PENDAPATAN ==========
        $pendapatan = ApbdesBidang::create([
            'apbdes_id' => $apbdes->id,
            'level' => 'bidang',
            'kode' => '4',
            'nama' => 'PENDAPATAN',
            'jenis' => 'pendapatan',
            'anggaran' => 1500000000,
            'realisasi' => 800000000,
            'urutan' => 1,
        ]);

        // Pendapatan Asli Desa
        $pad = ApbdesBidang::create([
            'apbdes_id' => $apbdes->id,
            'parent_id' => $pendapatan->id,
            'level' => 'sub_bidang',
            'kode' => '4.1',
            'nama' => 'Pendapatan Asli Desa',
            'jenis' => 'pendapatan',
            'anggaran' => 100000000,
            'realisasi' => 55000000,
            'urutan' => 1,
        ]);

        ApbdesBidang::create([
            'apbdes_id' => $apbdes->id,
            'parent_id' => $pad->id,
            'level' => 'kegiatan',
            'kode' => '4.1.1',
            'nama' => 'Hasil Usaha Desa',
            'jenis' => 'pendapatan',
            'anggaran' => 50000000,
            'realisasi' => 30000000,
            'urutan' => 1,
        ]);

        ApbdesBidang::create([
            'apbdes_id' => $apbdes->id,
            'parent_id' => $pad->id,
            'level' => 'kegiatan',
            'kode' => '4.1.2',
            'nama' => 'Hasil Aset Desa',
            'jenis' => 'pendapatan',
            'anggaran' => 30000000,
            'realisasi' => 15000000,
            'urutan' => 2,
        ]);

        ApbdesBidang::create([
            'apbdes_id' => $apbdes->id,
            'parent_id' => $pad->id,
            'level' => 'kegiatan',
            'kode' => '4.1.3',
            'nama' => 'Swadaya, Partisipasi dan Gotong Royong',
            'jenis' => 'pendapatan',
            'anggaran' => 20000000,
            'realisasi' => 10000000,
            'urutan' => 3,
        ]);

        // Transfer
        $transfer = ApbdesBidang::create([
            'apbdes_id' => $apbdes->id,
            'parent_id' => $pendapatan->id,
            'level' => 'sub_bidang',
            'kode' => '4.2',
            'nama' => 'Transfer',
            'jenis' => 'pendapatan',
            'anggaran' => 1400000000,
            'realisasi' => 745000000,
            'urutan' => 2,
        ]);

        ApbdesBidang::create([
            'apbdes_id' => $apbdes->id,
            'parent_id' => $transfer->id,
            'level' => 'kegiatan',
            'kode' => '4.2.1',
            'nama' => 'Dana Desa',
            'jenis' => 'pendapatan',
            'anggaran' => 800000000,
            'realisasi' => 400000000,
            'urutan' => 1,
        ]);

        ApbdesBidang::create([
            'apbdes_id' => $apbdes->id,
            'parent_id' => $transfer->id,
            'level' => 'kegiatan',
            'kode' => '4.2.2',
            'nama' => 'Alokasi Dana Desa (ADD)',
            'jenis' => 'pendapatan',
            'anggaran' => 400000000,
            'realisasi' => 200000000,
            'urutan' => 2,
        ]);

        ApbdesBidang::create([
            'apbdes_id' => $apbdes->id,
            'parent_id' => $transfer->id,
            'level' => 'kegiatan',
            'kode' => '4.2.3',
            'nama' => 'Bagi Hasil Pajak dan Retribusi',
            'jenis' => 'pendapatan',
            'anggaran' => 200000000,
            'realisasi' => 145000000,
            'urutan' => 3,
        ]);

        // ========== BELANJA ==========
        $belanja = ApbdesBidang::create([
            'apbdes_id' => $apbdes->id,
            'level' => 'bidang',
            'kode' => '5',
            'nama' => 'BELANJA',
            'jenis' => 'belanja',
            'anggaran' => 1450000000,
            'realisasi' => 750000000,
            'urutan' => 2,
        ]);

        // Bidang Penyelenggaraan Pemerintahan Desa
        $pemerintahan = ApbdesBidang::create([
            'apbdes_id' => $apbdes->id,
            'parent_id' => $belanja->id,
            'level' => 'sub_bidang',
            'kode' => '5.1',
            'nama' => 'Bidang Penyelenggaraan Pemerintahan Desa',
            'jenis' => 'belanja',
            'anggaran' => 500000000,
            'realisasi' => 280000000,
            'urutan' => 1,
        ]);

        ApbdesBidang::create([
            'apbdes_id' => $apbdes->id,
            'parent_id' => $pemerintahan->id,
            'level' => 'kegiatan',
            'kode' => '5.1.1',
            'nama' => 'Penghasilan Tetap dan Tunjangan Kepala Desa',
            'jenis' => 'belanja',
            'anggaran' => 120000000,
            'realisasi' => 60000000,
            'urutan' => 1,
        ]);

        ApbdesBidang::create([
            'apbdes_id' => $apbdes->id,
            'parent_id' => $pemerintahan->id,
            'level' => 'kegiatan',
            'kode' => '5.1.2',
            'nama' => 'Penghasilan Tetap dan Tunjangan Perangkat Desa',
            'jenis' => 'belanja',
            'anggaran' => 200000000,
            'realisasi' => 100000000,
            'urutan' => 2,
        ]);

        ApbdesBidang::create([
            'apbdes_id' => $apbdes->id,
            'parent_id' => $pemerintahan->id,
            'level' => 'kegiatan',
            'kode' => '5.1.3',
            'nama' => 'Operasional Kantor Desa',
            'jenis' => 'belanja',
            'anggaran' => 100000000,
            'realisasi' => 60000000,
            'urutan' => 3,
        ]);

        ApbdesBidang::create([
            'apbdes_id' => $apbdes->id,
            'parent_id' => $pemerintahan->id,
            'level' => 'kegiatan',
            'kode' => '5.1.4',
            'nama' => 'Operasional BPD',
            'jenis' => 'belanja',
            'anggaran' => 80000000,
            'realisasi' => 60000000,
            'urutan' => 4,
        ]);

        // Bidang Pelaksanaan Pembangunan Desa
        $pembangunan = ApbdesBidang::create([
            'apbdes_id' => $apbdes->id,
            'parent_id' => $belanja->id,
            'level' => 'sub_bidang',
            'kode' => '5.2',
            'nama' => 'Bidang Pelaksanaan Pembangunan Desa',
            'jenis' => 'belanja',
            'anggaran' => 600000000,
            'realisasi' => 300000000,
            'urutan' => 2,
        ]);

        ApbdesBidang::create([
            'apbdes_id' => $apbdes->id,
            'parent_id' => $pembangunan->id,
            'level' => 'kegiatan',
            'kode' => '5.2.1',
            'nama' => 'Pembangunan Jalan Desa',
            'jenis' => 'belanja',
            'anggaran' => 300000000,
            'realisasi' => 150000000,
            'urutan' => 1,
        ]);

        ApbdesBidang::create([
            'apbdes_id' => $apbdes->id,
            'parent_id' => $pembangunan->id,
            'level' => 'kegiatan',
            'kode' => '5.2.2',
            'nama' => 'Pembangunan Saluran Irigasi',
            'jenis' => 'belanja',
            'anggaran' => 200000000,
            'realisasi' => 100000000,
            'urutan' => 2,
        ]);

        ApbdesBidang::create([
            'apbdes_id' => $apbdes->id,
            'parent_id' => $pembangunan->id,
            'level' => 'kegiatan',
            'kode' => '5.2.3',
            'nama' => 'Pembangunan Balai Desa',
            'jenis' => 'belanja',
            'anggaran' => 100000000,
            'realisasi' => 50000000,
            'urutan' => 3,
        ]);

        // Bidang Pembinaan Kemasyarakatan
        $kemasyarakatan = ApbdesBidang::create([
            'apbdes_id' => $apbdes->id,
            'parent_id' => $belanja->id,
            'level' => 'sub_bidang',
            'kode' => '5.3',
            'nama' => 'Bidang Pembinaan Kemasyarakatan',
            'jenis' => 'belanja',
            'anggaran' => 200000000,
            'realisasi' => 100000000,
            'urutan' => 3,
        ]);

        ApbdesBidang::create([
            'apbdes_id' => $apbdes->id,
            'parent_id' => $kemasyarakatan->id,
            'level' => 'kegiatan',
            'kode' => '5.3.1',
            'nama' => 'Pembinaan Keamanan dan Ketertiban',
            'jenis' => 'belanja',
            'anggaran' => 50000000,
            'realisasi' => 25000000,
            'urutan' => 1,
        ]);

        ApbdesBidang::create([
            'apbdes_id' => $apbdes->id,
            'parent_id' => $kemasyarakatan->id,
            'level' => 'kegiatan',
            'kode' => '5.3.2',
            'nama' => 'Pembinaan Kerukunan Umat Beragama',
            'jenis' => 'belanja',
            'anggaran' => 50000000,
            'realisasi' => 25000000,
            'urutan' => 2,
        ]);

        ApbdesBidang::create([
            'apbdes_id' => $apbdes->id,
            'parent_id' => $kemasyarakatan->id,
            'level' => 'kegiatan',
            'kode' => '5.3.3',
            'nama' => 'Pembinaan Kesenian dan Sosial Budaya',
            'jenis' => 'belanja',
            'anggaran' => 100000000,
            'realisasi' => 50000000,
            'urutan' => 3,
        ]);

        // Bidang Pemberdayaan Masyarakat
        $pemberdayaan = ApbdesBidang::create([
            'apbdes_id' => $apbdes->id,
            'parent_id' => $belanja->id,
            'level' => 'sub_bidang',
            'kode' => '5.4',
            'nama' => 'Bidang Pemberdayaan Masyarakat',
            'jenis' => 'belanja',
            'anggaran' => 150000000,
            'realisasi' => 70000000,
            'urutan' => 4,
        ]);

        ApbdesBidang::create([
            'apbdes_id' => $apbdes->id,
            'parent_id' => $pemberdayaan->id,
            'level' => 'kegiatan',
            'kode' => '5.4.1',
            'nama' => 'Pelatihan Kepala Desa dan Perangkat Desa',
            'jenis' => 'belanja',
            'anggaran' => 50000000,
            'realisasi' => 25000000,
            'urutan' => 1,
        ]);

        ApbdesBidang::create([
            'apbdes_id' => $apbdes->id,
            'parent_id' => $pemberdayaan->id,
            'level' => 'kegiatan',
            'kode' => '5.4.2',
            'nama' => 'Peningkatan Kapasitas Masyarakat',
            'jenis' => 'belanja',
            'anggaran' => 100000000,
            'realisasi' => 45000000,
            'urutan' => 2,
        ]);

        $this->command->info('✅ Seeder APBDes selesai: 1 APBDes + 4 bidang + 16 sub-bidang/kegiatan');
    }
}
