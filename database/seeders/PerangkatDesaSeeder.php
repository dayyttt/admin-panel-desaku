<?php

namespace Database\Seeders;

use App\Models\PerangkatDesa;
use Illuminate\Database\Seeder;

class PerangkatDesaSeeder extends Seeder
{
    public function run(): void
    {
        $perangkat = [
            [
                'nama' => 'Budi Santoso, S.Sos',
                'nip' => '197505101998031001',
                'nik' => '8171051005750001',
                'jabatan' => 'Kepala Desa',
                'periode_mulai' => '2019-08-17',
                'periode_selesai' => '2025-08-17',
                'telepon' => '081234567890',
                'email' => 'kades@desalesane.id',
                'alamat' => 'Dusun Utara RT 001 RW 001',
                'aktif' => true,
                'tampil_web' => true,
                'urutan' => 1,
            ],
            [
                'nama' => 'Siti Aminah, S.AP',
                'nip' => '198203152005022001',
                'nik' => '8171051503820002',
                'jabatan' => 'Sekretaris Desa',
                'periode_mulai' => '2019-08-17',
                'periode_selesai' => '2025-08-17',
                'telepon' => '081234567891',
                'email' => 'sekdes@desalesane.id',
                'alamat' => 'Dusun Tengah RT 002 RW 001',
                'aktif' => true,
                'tampil_web' => true,
                'urutan' => 2,
            ],
            [
                'nama' => 'Ahmad Hidayat, SE',
                'nip' => '198506202010011002',
                'nik' => '8171052006850003',
                'jabatan' => 'Kaur Keuangan',
                'periode_mulai' => '2019-08-17',
                'periode_selesai' => '2025-08-17',
                'telepon' => '081234567892',
                'email' => 'keuangan@desalesane.id',
                'alamat' => 'Dusun Selatan RT 003 RW 002',
                'aktif' => true,
                'tampil_web' => true,
                'urutan' => 3,
            ],
            [
                'nama' => 'Dewi Lestari, S.Kom',
                'nik' => '8171055209880004',
                'jabatan' => 'Kaur Umum dan Perencanaan',
                'periode_mulai' => '2019-08-17',
                'periode_selesai' => '2025-08-17',
                'telepon' => '081234567893',
                'email' => 'umum@desalesane.id',
                'alamat' => 'Dusun Timur RT 004 RW 002',
                'aktif' => true,
                'tampil_web' => true,
                'urutan' => 4,
            ],
            [
                'nama' => 'Hendra Wijaya',
                'nik' => '8171051010900005',
                'jabatan' => 'Kaur Pemerintahan',
                'periode_mulai' => '2019-08-17',
                'periode_selesai' => '2025-08-17',
                'telepon' => '081234567894',
                'alamat' => 'Dusun Barat RT 005 RW 003',
                'aktif' => true,
                'tampil_web' => true,
                'urutan' => 5,
            ],
            [
                'nama' => 'Rina Marlina, S.Sos',
                'nik' => '8171055508920006',
                'jabatan' => 'Kaur Kesejahteraan',
                'periode_mulai' => '2019-08-17',
                'periode_selesai' => '2025-08-17',
                'telepon' => '081234567895',
                'alamat' => 'Dusun Utara RT 001 RW 001',
                'aktif' => true,
                'tampil_web' => true,
                'urutan' => 6,
            ],
            [
                'nama' => 'Bambang Suryanto',
                'nik' => '8171051508870007',
                'jabatan' => 'Kepala Dusun Utara',
                'periode_mulai' => '2019-08-17',
                'periode_selesai' => '2025-08-17',
                'telepon' => '081234567896',
                'alamat' => 'Dusun Utara RT 002 RW 001',
                'aktif' => true,
                'tampil_web' => true,
                'urutan' => 7,
            ],
            [
                'nama' => 'Yusuf Rahman',
                'nik' => '8171052012890008',
                'jabatan' => 'Kepala Dusun Tengah',
                'periode_mulai' => '2019-08-17',
                'periode_selesai' => '2025-08-17',
                'telepon' => '081234567897',
                'alamat' => 'Dusun Tengah RT 001 RW 001',
                'aktif' => true,
                'tampil_web' => true,
                'urutan' => 8,
            ],
            [
                'nama' => 'Fatimah Zahra',
                'nik' => '8171055103910009',
                'jabatan' => 'Kepala Dusun Selatan',
                'periode_mulai' => '2019-08-17',
                'periode_selesai' => '2025-08-17',
                'telepon' => '081234567898',
                'alamat' => 'Dusun Selatan RT 001 RW 002',
                'aktif' => true,
                'tampil_web' => true,
                'urutan' => 9,
            ],
            [
                'nama' => 'Agus Setiawan',
                'nik' => '8171051808880010',
                'jabatan' => 'Staf Administrasi',
                'periode_mulai' => '2020-01-01',
                'periode_selesai' => '2025-08-17',
                'telepon' => '081234567899',
                'alamat' => 'Dusun Timur RT 002 RW 002',
                'aktif' => true,
                'tampil_web' => false,
                'urutan' => 10,
            ],
        ];

        foreach ($perangkat as $p) {
            PerangkatDesa::create($p);
        }

        $this->command->info('✅ Seeder Perangkat Desa selesai: 10 perangkat');
    }
}
