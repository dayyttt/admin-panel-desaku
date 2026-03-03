<?php

namespace Database\Seeders;

use App\Models\TanahKasDesa;
use Illuminate\Database\Seeder;

class TanahKasDesaSeeder extends Seeder
{
    public function run(): void
    {
        $tanahList = [
            [
                'nama_bidang' => 'Tanah Kas Desa Blok A',
                'nomor_persil' => '001',
                'kelas_tanah' => 'S1',
                'luas' => 5000,
                'lokasi' => 'Dusun Utara, berbatasan dengan jalan raya',
                'latitude' => -3.2345,
                'longitude' => 128.1234,
                'status_tanah' => 'milik_desa',
                'nomor_sertifikat' => 'SHM-001/2010',
                'tanggal_sertifikat' => '2010-05-15',
                'penggunaan_tanah' => 'sawah',
                'nilai_tanah' => 250000000,
                'keterangan' => 'Tanah produktif, ditanami padi 2x setahun',
            ],
            [
                'nama_bidang' => 'Tanah Kas Desa Blok B',
                'nomor_persil' => '002',
                'kelas_tanah' => 'S2',
                'luas' => 3000,
                'lokasi' => 'Dusun Selatan, dekat sungai',
                'latitude' => -3.2456,
                'longitude' => 128.1345,
                'status_tanah' => 'milik_desa',
                'nomor_sertifikat' => 'SHM-002/2010',
                'tanggal_sertifikat' => '2010-05-15',
                'penggunaan_tanah' => 'kebun',
                'nilai_tanah' => 150000000,
                'keterangan' => 'Ditanami kelapa dan pisang',
            ],
            [
                'nama_bidang' => 'Lapangan Desa',
                'nomor_persil' => '003',
                'kelas_tanah' => 'S3',
                'luas' => 2000,
                'lokasi' => 'Tengah desa, dekat balai desa',
                'latitude' => -3.2367,
                'longitude' => 128.1256,
                'status_tanah' => 'milik_desa',
                'nomor_sertifikat' => 'SHM-003/2012',
                'tanggal_sertifikat' => '2012-08-20',
                'penggunaan_tanah' => 'lapangan',
                'nilai_tanah' => 400000000,
                'keterangan' => 'Digunakan untuk kegiatan olahraga dan upacara',
            ],
            [
                'nama_bidang' => 'Tanah Makam Desa',
                'nomor_persil' => '004',
                'kelas_tanah' => 'S3',
                'luas' => 1500,
                'lokasi' => 'Dusun Timur',
                'latitude' => -3.2378,
                'longitude' => 128.1367,
                'status_tanah' => 'milik_desa',
                'nomor_sertifikat' => 'SHM-004/2005',
                'tanggal_sertifikat' => '2005-03-10',
                'penggunaan_tanah' => 'lainnya',
                'nilai_tanah' => 100000000,
                'keterangan' => 'Tanah pemakaman umum desa',
            ],
            [
                'nama_bidang' => 'Tanah Sewa untuk Kios',
                'nomor_persil' => '005',
                'kelas_tanah' => 'S2',
                'luas' => 500,
                'lokasi' => 'Pinggir jalan raya',
                'latitude' => -3.2389,
                'longitude' => 128.1278,
                'status_tanah' => 'sewa',
                'penggunaan_tanah' => 'bangunan',
                'nilai_tanah' => 200000000,
                'keterangan' => 'Disewakan untuk kios, kontrak 5 tahun',
            ],
        ];

        foreach ($tanahList as $tanah) {
            TanahKasDesa::create($tanah);
        }

        $this->command->info('✅ Seeder Tanah Kas Desa selesai: 5 bidang tanah');
    }
}
