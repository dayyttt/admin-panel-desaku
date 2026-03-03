<?php

namespace Database\Seeders;

use App\Models\DokumenTtd;
use Illuminate\Database\Seeder;

class DokumenTtdSeeder extends Seeder
{
    public function run(): void
    {
        $dokumenTtd = [
            [
                'nama' => 'Muhammad Latuconsina',
                'jabatan' => 'Kepala Desa / Raja Negeri',
                'ttd_path' => null, // Bisa diisi path file TTD jika ada
                'stempel_path' => null, // Bisa diisi path file stempel jika ada
                'aktif' => true,
                'default' => true, // TTD default untuk surat
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Ahmad Sopaheluwakan',
                'jabatan' => 'Sekretaris Desa',
                'ttd_path' => null,
                'stempel_path' => null,
                'aktif' => true,
                'default' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Ibrahim Laturua',
                'jabatan' => 'Kaur Perencanaan',
                'ttd_path' => null,
                'stempel_path' => null,
                'aktif' => true,
                'default' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Fatima Tuasamu',
                'jabatan' => 'Kaur Keuangan',
                'ttd_path' => null,
                'stempel_path' => null,
                'aktif' => true,
                'default' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Plt. Kepala Desa',
                'jabatan' => 'Pelaksana Tugas Kepala Desa',
                'ttd_path' => null,
                'stempel_path' => null,
                'aktif' => false, // Tidak aktif, hanya digunakan saat Kades berhalangan
                'default' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DokumenTtd::insert($dokumenTtd);
        
        $this->command->info('✅ Berhasil membuat ' . count($dokumenTtd) . ' data dokumen TTD & Stempel');
        $this->command->info('ℹ️  TTD default: Muhammad Latuconsina (Kepala Desa)');
        $this->command->info('ℹ️  Untuk menambahkan file TTD & Stempel, upload melalui admin panel');
    }
}
