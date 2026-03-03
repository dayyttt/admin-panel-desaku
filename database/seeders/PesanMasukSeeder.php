<?php

namespace Database\Seeders;

use App\Models\WebKontak;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PesanMasukSeeder extends Seeder
{
    public function run(): void
    {
        $pesan = [
            [
                'nama' => 'Budi Santoso',
                'email' => 'budi.santoso@gmail.com',
                'subjek' => 'Pertanyaan tentang Persyaratan Surat Keterangan Domisili',
                'pesan' => 'Selamat pagi, saya ingin menanyakan persyaratan apa saja yang diperlukan untuk mengurus Surat Keterangan Domisili? Apakah bisa diurus secara online? Terima kasih.',
                'status' => 'baru',
                'created_at' => Carbon::now()->subDays(1),
                'updated_at' => Carbon::now()->subDays(1),
            ],
            [
                'nama' => 'Siti Aminah',
                'email' => 'siti.aminah@yahoo.com',
                'subjek' => 'Informasi Program Bantuan Sosial',
                'pesan' => 'Assalamualaikum, saya ingin menanyakan apakah ada program bantuan sosial untuk lansia di Desa Lesane? Bagaimana cara mendaftarnya? Mohon informasinya. Terima kasih.',
                'status' => 'dibalas',
                'catatan' => 'Sudah dibalas via email: Program PKH dan bantuan Dinas Sosial tersedia. Silakan datang ke kantor desa dengan KTP dan KK.',
                'dibaca_pada' => Carbon::now()->subDays(1)->addHours(2),
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subHours(12),
            ],
            [
                'nama' => 'Ahmad Hidayat',
                'email' => 'ahmad.hidayat@outlook.com',
                'subjek' => 'Keluhan Jalan Rusak di Dusun 2',
                'pesan' => 'Yth. Pemerintah Desa Lesane, saya ingin melaporkan kondisi jalan di Dusun 2 RT 003 yang rusak parah dan berlubang. Mohon dapat segera diperbaiki karena mengganggu aktivitas warga. Terima kasih.',
                'status' => 'dibaca',
                'catatan' => 'Sudah diteruskan ke Kaur Pembangunan untuk ditindaklanjuti',
                'dibaca_pada' => Carbon::now()->subDays(2)->addHours(5),
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(2)->addHours(5),
            ],
            [
                'nama' => 'Dewi Lestari',
                'email' => 'dewi.lestari@gmail.com',
                'subjek' => 'Jadwal Posyandu Bulan Maret',
                'pesan' => 'Selamat siang, saya ingin menanyakan jadwal posyandu untuk bulan Maret 2026. Anak saya perlu imunisasi. Mohon informasinya. Terima kasih.',
                'status' => 'dibalas',
                'catatan' => 'Sudah dibalas: Jadwal posyandu setiap Rabu minggu ke-2 dan ke-4 (12 dan 26 Maret) pukul 08.00-11.00 WIT',
                'dibaca_pada' => Carbon::now()->subDays(2)->addHours(1),
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(2)->addHours(3),
            ],
            [
                'nama' => 'Rizki Pratama',
                'email' => 'rizki.pratama@gmail.com',
                'subjek' => 'Permohonan Izin Kegiatan Karang Taruna',
                'pesan' => 'Kepada Yth. Kepala Desa Lesane, kami dari Karang Taruna Desa Lesane ingin mengajukan permohonan izin untuk mengadakan kegiatan bakti sosial dan donor darah pada tanggal 20 Maret 2026. Mohon persetujuannya. Terima kasih.',
                'status' => 'baru',
                'created_at' => Carbon::now()->subHours(6),
                'updated_at' => Carbon::now()->subHours(6),
            ],
            [
                'nama' => 'Fatimah Zahra',
                'email' => 'fatimah.zahra@yahoo.com',
                'subjek' => 'Informasi Pendaftaran UMKM',
                'pesan' => 'Assalamualaikum, saya memiliki usaha keripik pisang dan ingin mendaftarkan UMKM saya. Bagaimana prosedurnya dan apakah ada biaya? Mohon informasinya. Terima kasih.',
                'status' => 'baru',
                'created_at' => Carbon::now()->subHours(3),
                'updated_at' => Carbon::now()->subHours(3),
            ],
            [
                'nama' => 'Hendra Wijaya',
                'email' => 'hendra.wijaya@gmail.com',
                'subjek' => 'Saran Pembangunan Taman Desa',
                'pesan' => 'Kepada Pemerintah Desa Lesane, saya ingin memberikan saran untuk membangun taman desa sebagai ruang publik warga. Lokasi yang cocok mungkin di dekat balai desa. Semoga bisa dipertimbangkan. Terima kasih.',
                'status' => 'dibaca',
                'catatan' => 'Saran bagus, akan dibahas dalam Musrenbangdes',
                'dibaca_pada' => Carbon::now()->subDays(3)->addHours(8),
                'created_at' => Carbon::now()->subDays(4),
                'updated_at' => Carbon::now()->subDays(3)->addHours(8),
            ],
            [
                'nama' => 'Linda Kusuma',
                'email' => 'linda.kusuma@outlook.com',
                'subjek' => 'Pertanyaan Tentang APBDes',
                'pesan' => 'Selamat siang, saya ingin menanyakan bagaimana cara mengakses informasi APBDes Desa Lesane tahun 2026? Apakah ada laporan yang bisa diakses publik? Terima kasih.',
                'status' => 'selesai',
                'catatan' => 'Sudah dibalas: Informasi APBDes dapat diakses di menu Statistik website atau papan informasi di kantor desa',
                'dibaca_pada' => Carbon::now()->subDays(1)->addHours(1),
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(1)->addHours(2),
            ],
        ];

        foreach ($pesan as $p) {
            WebKontak::create($p);
        }

        $this->command->info('✅ Berhasil membuat ' . count($pesan) . ' pesan masuk');
        $this->command->info('📊 Status: ' . collect($pesan)->where('status', 'baru')->count() . ' baru, ' . 
                            collect($pesan)->where('status', 'dibaca')->count() . ' dibaca, ' . 
                            collect($pesan)->where('status', 'dibalas')->count() . ' dibalas, ' . 
                            collect($pesan)->where('status', 'selesai')->count() . ' selesai');
    }
}
