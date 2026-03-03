<?php

namespace Database\Seeders;

use App\Models\ProdukHukum;
use App\Models\InformasiPublik;
use App\Models\ArsipDesa;
use Illuminate\Database\Seeder;

class SekretariatSeeder extends Seeder
{
    public function run(): void
    {
        // Produk Hukum
        $produkHukums = [
            [
                'jenis' => 'perdes',
                'nomor' => '01/PERDES/2026',
                'tahun' => 2026,
                'judul' => 'Peraturan Desa tentang APBDes Tahun 2026',
                'tentang' => 'Anggaran Pendapatan dan Belanja Desa Tahun Anggaran 2026',
                'tanggal_ditetapkan' => '2026-01-15',
                'tanggal_berlaku' => '2026-01-15',
                'tampil_publik' => true,
                'status' => 'aktif',
            ],
            [
                'jenis' => 'perdes',
                'nomor' => '02/PERDES/2025',
                'tahun' => 2025,
                'judul' => 'Peraturan Desa tentang RPJMDes 2025-2031',
                'tentang' => 'Rencana Pembangunan Jangka Menengah Desa Tahun 2025-2031',
                'tanggal_ditetapkan' => '2025-03-20',
                'tanggal_berlaku' => '2025-04-01',
                'tampil_publik' => true,
                'status' => 'aktif',
            ],
            [
                'jenis' => 'perkades',
                'nomor' => '05/PERKADES/2026',
                'tahun' => 2026,
                'judul' => 'Peraturan Kepala Desa tentang Pembentukan Tim Pengelola Dana Desa',
                'tentang' => 'Pembentukan dan Susunan Tim Pengelola Dana Desa',
                'tanggal_ditetapkan' => '2026-02-01',
                'tanggal_berlaku' => '2026-02-01',
                'tampil_publik' => true,
                'status' => 'aktif',
            ],
            [
                'jenis' => 'sk',
                'nomor' => '10/SK/2026',
                'tahun' => 2026,
                'judul' => 'Surat Keputusan tentang Pengangkatan Perangkat Desa',
                'tentang' => 'Pengangkatan dan Penetapan Perangkat Desa Periode 2026-2032',
                'tanggal_ditetapkan' => '2026-01-05',
                'tanggal_berlaku' => '2026-01-05',
                'tampil_publik' => false,
                'status' => 'aktif',
            ],
            [
                'jenis' => 'keputusan_bpd',
                'nomor' => '01/KEP-BPD/2026',
                'tahun' => 2026,
                'judul' => 'Keputusan BPD tentang Persetujuan APBDes 2026',
                'tentang' => 'Persetujuan Rancangan APBDes Tahun Anggaran 2026',
                'tanggal_ditetapkan' => '2026-01-10',
                'tanggal_berlaku' => '2026-01-10',
                'tampil_publik' => true,
                'status' => 'aktif',
            ],
        ];

        foreach ($produkHukums as $produk) {
            ProdukHukum::create($produk);
        }

        // Informasi Publik
        $informasiPubliks = [
            [
                'judul' => 'LPPD Desa Lesane Tahun 2025',
                'kategori' => 'lppd',
                'tahun' => 2025,
                'deskripsi' => 'Laporan Penyelenggaraan Pemerintahan Desa Tahun 2025',
                'aktif' => true,
                'urutan' => 1,
            ],
            [
                'judul' => 'APBDes Desa Lesane Tahun 2026',
                'kategori' => 'apbdes',
                'tahun' => 2026,
                'deskripsi' => 'Anggaran Pendapatan dan Belanja Desa Tahun Anggaran 2026',
                'aktif' => true,
                'urutan' => 2,
            ],
            [
                'judul' => 'RPJMDes Desa Lesane 2025-2031',
                'kategori' => 'rpjmdes',
                'tahun' => 2025,
                'deskripsi' => 'Rencana Pembangunan Jangka Menengah Desa Periode 2025-2031',
                'aktif' => true,
                'urutan' => 3,
            ],
            [
                'judul' => 'RKPDes Desa Lesane Tahun 2026',
                'kategori' => 'rkpdes',
                'tahun' => 2026,
                'deskripsi' => 'Rencana Kerja Pemerintah Desa Tahun 2026',
                'aktif' => true,
                'urutan' => 4,
            ],
            [
                'judul' => 'Peraturan Desa Nomor 1 Tahun 2026',
                'kategori' => 'perdes',
                'tahun' => 2026,
                'deskripsi' => 'Peraturan Desa tentang APBDes Tahun 2026',
                'aktif' => true,
                'urutan' => 5,
            ],
        ];

        foreach ($informasiPubliks as $info) {
            InformasiPublik::create($info);
        }

        // Arsip Desa
        $arsips = [
            [
                'judul' => 'Surat Masuk dari Kecamatan - Januari 2026',
                'kode_arsip' => 'SM-001/2026',
                'kategori' => 'surat_masuk',
                'tahun' => 2026,
                'deskripsi' => 'Surat undangan rapat koordinasi kecamatan',
                'file_path' => 'arsip/sm-001-2026.pdf',
                'lokasi_fisik' => 'Rak A, Lemari 1',
                'jumlah_halaman' => 2,
                'kondisi' => 'baik',
            ],
            [
                'judul' => 'Surat Keluar ke Kabupaten - Januari 2026',
                'kode_arsip' => 'SK-001/2026',
                'kategori' => 'surat_keluar',
                'tahun' => 2026,
                'deskripsi' => 'Surat permohonan bantuan pembangunan jalan',
                'file_path' => 'arsip/sk-001-2026.pdf',
                'lokasi_fisik' => 'Rak A, Lemari 2',
                'jumlah_halaman' => 3,
                'kondisi' => 'baik',
            ],
            [
                'judul' => 'SK Pengangkatan Perangkat Desa 2026',
                'kode_arsip' => 'SK-PD-001/2026',
                'kategori' => 'sk',
                'tahun' => 2026,
                'deskripsi' => 'Surat Keputusan Pengangkatan Perangkat Desa Periode 2026-2032',
                'file_path' => 'arsip/sk-pd-001-2026.pdf',
                'lokasi_fisik' => 'Rak B, Lemari 1',
                'jumlah_halaman' => 5,
                'kondisi' => 'baik',
            ],
            [
                'judul' => 'Peraturan Desa Nomor 1 Tahun 2026',
                'kode_arsip' => 'PERDES-001/2026',
                'kategori' => 'perdes',
                'tahun' => 2026,
                'deskripsi' => 'Peraturan Desa tentang APBDes Tahun 2026',
                'file_path' => 'arsip/perdes-001-2026.pdf',
                'lokasi_fisik' => 'Rak B, Lemari 2',
                'jumlah_halaman' => 15,
                'kondisi' => 'baik',
            ],
            [
                'judul' => 'Laporan Keuangan Semester I Tahun 2025',
                'kode_arsip' => 'LAP-KEU-S1/2025',
                'kategori' => 'laporan',
                'tahun' => 2025,
                'deskripsi' => 'Laporan Realisasi APBDes Semester I Tahun 2025',
                'file_path' => 'arsip/lap-keu-s1-2025.pdf',
                'lokasi_fisik' => 'Rak C, Lemari 1',
                'jumlah_halaman' => 25,
                'kondisi' => 'baik',
            ],
            [
                'judul' => 'Arsip Lama - Surat Masuk 2020',
                'kode_arsip' => 'SM-LAMA/2020',
                'kategori' => 'surat_masuk',
                'tahun' => 2020,
                'deskripsi' => 'Kumpulan surat masuk tahun 2020. Beberapa halaman mulai menguning.',
                'file_path' => 'arsip/sm-lama-2020.pdf',
                'lokasi_fisik' => 'Rak D, Lemari 3',
                'jumlah_halaman' => 50,
                'kondisi' => 'rusak_ringan',
            ],
        ];

        foreach ($arsips as $arsip) {
            ArsipDesa::create($arsip);
        }

        $this->command->info('✅ Seeder Sekretariat selesai: 5 produk hukum + 5 informasi publik + 6 arsip');
    }
}
