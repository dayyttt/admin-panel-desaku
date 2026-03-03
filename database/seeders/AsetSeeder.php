<?php

namespace Database\Seeders;

use App\Models\AsetKategori;
use App\Models\Aset;
use Illuminate\Database\Seeder;

class AsetSeeder extends Seeder
{
    public function run(): void
    {
        // Kategori Aset
        $kategoris = [
            ['nama' => 'Tanah', 'kode' => 'TNH', 'keterangan' => 'Tanah milik desa'],
            ['nama' => 'Bangunan', 'kode' => 'BGN', 'keterangan' => 'Bangunan dan gedung'],
            ['nama' => 'Kendaraan', 'kode' => 'KND', 'keterangan' => 'Kendaraan bermotor'],
            ['nama' => 'Peralatan', 'kode' => 'PRL', 'keterangan' => 'Peralatan dan mesin'],
            ['nama' => 'Elektronik', 'kode' => 'ELK', 'keterangan' => 'Peralatan elektronik'],
        ];

        foreach ($kategoris as $kategori) {
            AsetKategori::create($kategori);
        }

        // Aset Tanah
        Aset::create([
            'kategori_id' => 1,
            'nama' => 'Tanah Kantor Desa',
            'kode_inventaris' => 'TNH-001',
            'tahun_perolehan' => 1985,
            'cara_perolehan' => 'hibah',
            'nilai_perolehan' => 500000000,
            'kondisi' => 'baik',
            'lokasi' => 'Jl. Raya Lesane No. 1',
            'luas' => 1000,
            'satuan' => 'm²',
            'aktif' => true,
        ]);

        // Aset Bangunan
        Aset::create([
            'kategori_id' => 2,
            'nama' => 'Gedung Kantor Desa',
            'kode_inventaris' => 'BGN-001',
            'tahun_perolehan' => 1990,
            'cara_perolehan' => 'dana_desa',
            'nilai_perolehan' => 800000000,
            'kondisi' => 'baik',
            'lokasi' => 'Jl. Raya Lesane No. 1',
            'luas' => 300,
            'satuan' => 'm²',
            'aktif' => true,
        ]);

        Aset::create([
            'kategori_id' => 2,
            'nama' => 'Balai Desa',
            'kode_inventaris' => 'BGN-002',
            'tahun_perolehan' => 2015,
            'cara_perolehan' => 'dana_desa',
            'nilai_perolehan' => 600000000,
            'kondisi' => 'baik',
            'lokasi' => 'Dusun Tengah',
            'luas' => 200,
            'satuan' => 'm²',
            'aktif' => true,
        ]);

        // Aset Kendaraan
        Aset::create([
            'kategori_id' => 3,
            'nama' => 'Mobil Operasional Desa',
            'kode_inventaris' => 'KND-001',
            'tahun_perolehan' => 2020,
            'cara_perolehan' => 'beli',
            'nilai_perolehan' => 250000000,
            'kondisi' => 'baik',
            'lokasi' => 'Kantor Desa',
            'volume' => 1,
            'satuan' => 'unit',
            'aktif' => true,
        ]);

        Aset::create([
            'kategori_id' => 3,
            'nama' => 'Motor Dinas',
            'kode_inventaris' => 'KND-002',
            'tahun_perolehan' => 2022,
            'cara_perolehan' => 'beli',
            'nilai_perolehan' => 18000000,
            'kondisi' => 'baik',
            'lokasi' => 'Kantor Desa',
            'volume' => 2,
            'satuan' => 'unit',
            'aktif' => true,
        ]);

        // Aset Peralatan
        Aset::create([
            'kategori_id' => 4,
            'nama' => 'Meja Kerja',
            'kode_inventaris' => 'PRL-001',
            'tahun_perolehan' => 2019,
            'cara_perolehan' => 'beli',
            'nilai_perolehan' => 15000000,
            'kondisi' => 'baik',
            'lokasi' => 'Kantor Desa',
            'volume' => 10,
            'satuan' => 'unit',
            'aktif' => true,
        ]);

        Aset::create([
            'kategori_id' => 4,
            'nama' => 'Kursi Kantor',
            'kode_inventaris' => 'PRL-002',
            'tahun_perolehan' => 2019,
            'cara_perolehan' => 'beli',
            'nilai_perolehan' => 10000000,
            'kondisi' => 'baik',
            'lokasi' => 'Kantor Desa',
            'volume' => 15,
            'satuan' => 'unit',
            'aktif' => true,
        ]);

        // Aset Elektronik
        Aset::create([
            'kategori_id' => 5,
            'nama' => 'Komputer Desktop',
            'kode_inventaris' => 'ELK-001',
            'tahun_perolehan' => 2021,
            'cara_perolehan' => 'beli',
            'nilai_perolehan' => 40000000,
            'kondisi' => 'baik',
            'lokasi' => 'Kantor Desa',
            'volume' => 5,
            'satuan' => 'unit',
            'aktif' => true,
        ]);

        Aset::create([
            'kategori_id' => 5,
            'nama' => 'Printer',
            'kode_inventaris' => 'ELK-002',
            'tahun_perolehan' => 2021,
            'cara_perolehan' => 'beli',
            'nilai_perolehan' => 6000000,
            'kondisi' => 'baik',
            'lokasi' => 'Kantor Desa',
            'volume' => 2,
            'satuan' => 'unit',
            'aktif' => true,
        ]);

        Aset::create([
            'kategori_id' => 5,
            'nama' => 'Proyektor',
            'kode_inventaris' => 'ELK-003',
            'tahun_perolehan' => 2020,
            'cara_perolehan' => 'beli',
            'nilai_perolehan' => 8000000,
            'kondisi' => 'rusak_ringan',
            'lokasi' => 'Balai Desa',
            'volume' => 1,
            'satuan' => 'unit',
            'keterangan' => 'Lampu proyektor perlu diganti',
            'aktif' => true,
        ]);

        $this->command->info('✅ Seeder Aset selesai: 5 kategori + 10 aset');
    }
}
