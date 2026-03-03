<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DesaInfo;

class DesaInfoSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🌱 Starting Desa Info Seeder...');
        $this->command->newLine();

        // Truncate
        DesaInfo::truncate();

        // 1. PROFIL DESA
        $this->command->info('📋 Creating Profil Desa...');
        DesaInfo::create([
            'key' => 'profil',
            'data' => [
                'nama' => 'Desa Lesane',
                'kecamatan' => 'Kota Masohi',
                'kabupaten' => 'Maluku Tengah',
                'provinsi' => 'Maluku',
                'kode_pos' => '97511',
                'luas_wilayah' => '5.0',
                'ketinggian' => '15',
                'jumlah_penduduk' => 2847,
                'jumlah_kk' => 712,
                'sambutan' => 'Assalamu\'alaikum Warahmatullahi Wabarakatuh. Selamat datang di website resmi Desa Lesane. Kami berkomitmen untuk memberikan pelayanan terbaik kepada masyarakat dan membangun desa yang maju, mandiri, dan sejahtera. Website ini hadir sebagai wujud transparansi dan akuntabilitas pemerintahan desa dalam menjalankan tugas dan fungsinya. Mari bersama-sama kita wujudkan Desa Lesane yang lebih baik untuk generasi mendatang. Wassalamu\'alaikum Warahmatullahi Wabarakatuh.',
            ],
            'aktif' => true,
        ]);
        $this->command->info('   ✅ Profil Desa created');

        // 2. SEJARAH
        $this->command->info('📜 Creating Sejarah...');
        DesaInfo::create([
            'key' => 'sejarah',
            'data' => [
                'konten' => 'Desa Lesane adalah sebuah negeri adat yang telah berdiri sejak abad ke-17, terletak di pesisir Teluk Masohi, Kabupaten Maluku Tengah. Nama "Lesane" berasal dari bahasa lokal yang berarti "tempat berkumpul" atau "tempat pertemuan", mencerminkan fungsi historis wilayah ini sebagai titik pertemuan para nelayan dan pedagang dari berbagai negeri.

Pada masa kolonial Belanda, Desa Lesane menjadi salah satu pusat pengumpulan hasil laut dan rempah-rempah, khususnya cengkeh dan pala yang menjadi komoditas utama Maluku. Struktur pemerintahan tradisional yang dipimpin oleh seorang Raja atau Kepala Negeri tetap dipertahankan hingga kini, meskipun telah disesuaikan dengan sistem pemerintahan desa modern.

Masyarakat Desa Lesane dikenal dengan kearifan lokal "Pela Gandong", sebuah ikatan persaudaraan antar negeri yang telah ada sejak ratusan tahun lalu. Tradisi ini menjadi fondasi kuat dalam menjaga kerukunan dan gotong royong masyarakat hingga saat ini.',
                'timeline' => [
                    ['tahun' => '1650', 'peristiwa' => 'Berdirinya pemukiman awal Lesane oleh para nelayan dan pedagang'],
                    ['tahun' => '1850', 'peristiwa' => 'Pengangkatan Raja Lesane pertama dan pembentukan struktur pemerintahan adat'],
                    ['tahun' => '1920', 'peristiwa' => 'Lesane menjadi pusat perdagangan rempah-rempah di Teluk Masohi'],
                    ['tahun' => '1945', 'peristiwa' => 'Proklamasi kemerdekaan Indonesia, Lesane resmi menjadi bagian dari NKRI'],
                    ['tahun' => '1985', 'peristiwa' => 'Listrik masuk desa, menandai era modernisasi infrastruktur'],
                    ['tahun' => '2000', 'peristiwa' => 'Pembangunan dermaga nelayan dan pasar tradisional'],
                    ['tahun' => '2020', 'peristiwa' => 'Peluncuran website desa dan digitalisasi layanan publik'],
                ],
            ],
            'aktif' => true,
        ]);
        $this->command->info('   ✅ Sejarah created');

        // 3. VISI MISI
        $this->command->info('🎯 Creating Visi Misi...');
        DesaInfo::create([
            'key' => 'visi_misi',
            'data' => [
                'visi' => 'Terwujudnya Desa Lesane yang Maju, Mandiri, Sejahtera, dan Berbudaya Berbasis Potensi Lokal pada Tahun 2027',
                'misi' => [
                    'Meningkatkan kualitas sumber daya manusia melalui pendidikan dan pelatihan keterampilan',
                    'Mengembangkan ekonomi kerakyatan berbasis potensi lokal, khususnya sektor kelautan dan pertanian',
                    'Memperbaiki dan membangun infrastruktur desa yang mendukung aktivitas ekonomi dan sosial masyarakat',
                    'Meningkatkan kualitas pelayanan publik yang cepat, mudah, dan transparan',
                    'Melestarikan nilai-nilai budaya lokal dan kearifan tradisional masyarakat',
                    'Mewujudkan tata kelola pemerintahan desa yang baik, bersih, dan akuntabel',
                ],
            ],
            'aktif' => true,
        ]);
        $this->command->info('   ✅ Visi Misi created');

        // 4. GEOGRAFI
        $this->command->info('🗺️  Creating Geografi...');
        DesaInfo::create([
            'key' => 'geografi',
            'data' => [
                'koordinat' => [
                    'lintang' => '3°20\'45" LS',
                    'bujur' => '128°55\'30" BT',
                ],
                'batas_wilayah' => [
                    'utara' => 'Teluk Masohi',
                    'selatan' => 'Desa Namaelo',
                    'timur' => 'Desa Rumah Tiga',
                    'barat' => 'Desa Lesane Barat',
                ],
                'topografi' => 'Dataran rendah pesisir',
                'iklim' => 'Tropis dengan curah hujan tinggi',
                'jarak_ke_kota_kabupaten' => '3 km ke Kota Masohi',
            ],
            'aktif' => true,
        ]);
        $this->command->info('   ✅ Geografi created');

        // 5. DEMOGRAFI
        $this->command->info('👥 Creating Demografi...');
        DesaInfo::create([
            'key' => 'demografi',
            'data' => [
                'jumlah_penduduk' => 2847,
                'laki_laki' => 1423,
                'perempuan' => 1424,
                'jumlah_kk' => 712,
                'kepadatan' => '569 jiwa/km²',
            ],
            'aktif' => true,
        ]);
        $this->command->info('   ✅ Demografi created');

        // 6. FASILITAS UMUM
        $this->command->info('🏢 Creating Fasilitas Umum...');
        DesaInfo::create([
            'key' => 'fasilitas',
            'data' => [
                'pendidikan' => [
                    ['nama' => 'TK Negeri Pembina', 'jumlah' => 1],
                    ['nama' => 'SD Negeri', 'jumlah' => 2],
                    ['nama' => 'SMP Negeri', 'jumlah' => 1],
                ],
                'kesehatan' => [
                    ['nama' => 'Puskesmas Pembantu', 'jumlah' => 1],
                    ['nama' => 'Posyandu', 'jumlah' => 4],
                    ['nama' => 'Polindes', 'jumlah' => 1],
                ],
                'ibadah' => [
                    ['nama' => 'Masjid', 'jumlah' => 3],
                    ['nama' => 'Musholla', 'jumlah' => 5],
                    ['nama' => 'Gereja', 'jumlah' => 1],
                ],
                'ekonomi' => [
                    ['nama' => 'Pasar Tradisional', 'jumlah' => 1],
                    ['nama' => 'Kios/Warung', 'jumlah' => 28],
                    ['nama' => 'Dermaga Nelayan', 'jumlah' => 1],
                ],
                'pemerintahan' => [
                    ['nama' => 'Kantor Desa', 'jumlah' => 1],
                    ['nama' => 'Balai Desa', 'jumlah' => 1],
                ],
                'olahraga' => [
                    ['nama' => 'Lapangan Sepak Bola', 'jumlah' => 1],
                    ['nama' => 'Lapangan Voli', 'jumlah' => 2],
                ],
            ],
            'aktif' => true,
        ]);
        $this->command->info('   ✅ Fasilitas Umum created');

        // 7. PEMERINTAHAN
        $this->command->info('🏛️  Creating Pemerintahan...');
        DesaInfo::create([
            'key' => 'pemerintahan',
            'data' => [
                'kepala_desa' => [
                    'nama' => 'Muhammad Saleh Lestaluhu',
                    'jabatan' => 'Kepala Desa / Raja Negeri',
                    'periode' => '2021 - 2027',
                ],
                'perangkat_desa' => [
                    ['nama' => 'Ahmad Latuconsina', 'jabatan' => 'Sekretaris Desa', 'bidang' => 'Administrasi & Tata Usaha'],
                    ['nama' => 'Fatimah Tuasikal', 'jabatan' => 'Kaur Keuangan', 'bidang' => 'Pengelolaan Keuangan'],
                    ['nama' => 'Ibrahim Rehatta', 'jabatan' => 'Kaur Perencanaan', 'bidang' => 'Perencanaan Pembangunan'],
                    ['nama' => 'Siti Wattimena', 'jabatan' => 'Kaur Umum', 'bidang' => 'Administrasi Umum'],
                    ['nama' => 'Yusuf Lestaluhu', 'jabatan' => 'Kasi Pemerintahan', 'bidang' => 'Pemerintahan & Kependudukan'],
                    ['nama' => 'Aisyah Pattiselanno', 'jabatan' => 'Kasi Kesejahteraan', 'bidang' => 'Kesejahteraan Sosial'],
                    ['nama' => 'Umar Sahetapy', 'jabatan' => 'Kasi Pelayanan', 'bidang' => 'Pelayanan Publik'],
                    ['nama' => 'Rahma Tuhumury', 'jabatan' => 'Kadus I', 'bidang' => 'Dusun Lesane Timur'],
                    ['nama' => 'Hasan Leatemia', 'jabatan' => 'Kadus II', 'bidang' => 'Dusun Lesane Barat'],
                    ['nama' => 'Zainab Soumokil', 'jabatan' => 'Kadus III', 'bidang' => 'Dusun Lesane Tengah'],
                ],
                'bpd' => [
                    ['nama' => 'Abdul Kadir Tuasikal', 'jabatan' => 'Ketua BPD'],
                    ['nama' => 'Maryam Latuconsina', 'jabatan' => 'Wakil Ketua BPD'],
                    ['nama' => 'Ismail Rehatta', 'jabatan' => 'Sekretaris BPD'],
                    ['nama' => 'Aminah Wattimena', 'jabatan' => 'Anggota BPD'],
                    ['nama' => 'Hamzah Pattiselanno', 'jabatan' => 'Anggota BPD'],
                ],
                'kepala_rt' => [
                    'RT 001 - Bapak Saiful Tuhumury',
                    'RT 002 - Bapak Ridwan Leatemia',
                    'RT 003 - Bapak Mansur Soumokil',
                    'RT 004 - Bapak Karim Latuconsina',
                    'RT 005 - Bapak Yusran Rehatta',
                    'RT 006 - Bapak Amir Wattimena',
                    'RT 007 - Bapak Ruslan Tuasikal',
                    'RT 008 - Bapak Faisal Pattiselanno',
                ],
                'jam_kerja' => [
                    'hari_kerja' => 'Senin - Jumat',
                    'jam' => '08:00 - 16:00 WIT',
                    'istirahat' => '12:00 - 13:00 WIT',
                    'sabtu' => '08:00 - 12:00 WIT (Terbatas)',
                    'minggu' => 'Tutup',
                ],
            ],
            'aktif' => true,
        ]);
        $this->command->info('   ✅ Pemerintahan created');

        // 8. KONTAK
        $this->command->info('📞 Creating Kontak...');
        DesaInfo::create([
            'key' => 'kontak',
            'data' => [
                'alamat' => 'Jl. Raya Lesane No. 1, Kota Masohi, Kabupaten Maluku Tengah, Provinsi Maluku 97511',
                'telepon' => '(0914) 123456',
                'email' => 'desalesane@malukutengahkab.go.id',
                'website' => 'https://desalesane.id',
                'jam_operasional' => [
                    'hari_kerja' => 'Senin - Jumat',
                    'jam' => '08:00 - 16:00 WIT',
                    'sabtu' => '08:00 - 12:00 WIT (Terbatas)',
                    'minggu' => 'Tutup',
                ],
                'media_sosial' => [
                    'facebook' => '@DesaLesane',
                    'instagram' => '@desalesane',
                    'youtube' => 'Desa Lesane Official',
                ],
            ],
            'aktif' => true,
        ]);
        $this->command->info('   ✅ Kontak created');

        // 9. LAYANAN PUBLIK
        $this->command->info('📋 Creating Layanan Publik...');
        DesaInfo::create([
            'key' => 'layanan',
            'data' => [
                'administrasi' => [
                    [
                        'nama' => 'Surat Pengantar KTP',
                        'deskripsi' => 'Pengantar pembuatan atau perpanjangan Kartu Tanda Penduduk (KTP) ke Disdukcapil',
                        'persyaratan' => [
                            'Fotokopi Kartu Keluarga',
                            'Surat pengantar RT/RW',
                            'Pas foto 3x4 (2 lembar)',
                            'KTP lama (jika perpanjangan)',
                        ],
                        'waktu' => '1 hari kerja',
                        'biaya' => 'Gratis',
                    ],
                    [
                        'nama' => 'Surat Pengantar Kartu Keluarga',
                        'deskripsi' => 'Pengantar pembuatan, pembaruan, atau pecah Kartu Keluarga',
                        'persyaratan' => [
                            'KTP asli dan fotokopi',
                            'KK lama (jika pembaruan)',
                            'Surat nikah/akta kelahiran',
                            'Surat pengantar RT/RW',
                        ],
                        'waktu' => '1 hari kerja',
                        'biaya' => 'Gratis',
                    ],
                    [
                        'nama' => 'Surat Keterangan Kelahiran',
                        'deskripsi' => 'Surat keterangan untuk pengurusan akta kelahiran anak',
                        'persyaratan' => [
                            'KTP orang tua',
                            'Kartu Keluarga',
                            'Surat keterangan lahir dari bidan/RS',
                            'Surat nikah orang tua',
                        ],
                        'waktu' => '1 hari kerja',
                        'biaya' => 'Gratis',
                    ],
                    [
                        'nama' => 'Surat Keterangan Domisili',
                        'deskripsi' => 'Surat keterangan bahwa seseorang berdomisili di wilayah Desa Lesane',
                        'persyaratan' => [
                            'Fotokopi KTP',
                            'Fotokopi Kartu Keluarga',
                            'Surat pengantar RT/RW',
                        ],
                        'waktu' => '1 hari kerja',
                        'biaya' => 'Gratis',
                    ],
                ],
                'surat' => [
                    [
                        'nama' => 'Surat Keterangan Usaha (SKU)',
                        'deskripsi' => 'Keterangan untuk pelaku usaha mikro dan kecil di wilayah desa',
                        'persyaratan' => [
                            'Fotokopi KTP',
                            'Fotokopi KK',
                            'Surat pengantar RT/RW',
                            'Foto lokasi usaha',
                        ],
                        'waktu' => '1-2 hari kerja',
                        'biaya' => 'Gratis',
                    ],
                    [
                        'nama' => 'Surat Keterangan Tidak Mampu (SKTM)',
                        'deskripsi' => 'Untuk keperluan keringanan biaya pendidikan, kesehatan, atau bantuan sosial',
                        'persyaratan' => [
                            'Fotokopi KTP',
                            'Fotokopi KK',
                            'Surat pengantar RT/RW',
                            'Surat pernyataan tidak mampu',
                        ],
                        'waktu' => '1 hari kerja',
                        'biaya' => 'Gratis',
                    ],
                    [
                        'nama' => 'Surat Keterangan Kematian',
                        'deskripsi' => 'Untuk pengurusan administrasi terkait kematian warga desa',
                        'persyaratan' => [
                            'KTP almarhum/almarhumah',
                            'Kartu Keluarga',
                            'Surat keterangan dari RT/RW',
                            'Surat keterangan dari rumah sakit (jika ada)',
                        ],
                        'waktu' => '1 hari kerja',
                        'biaya' => 'Gratis',
                    ],
                    [
                        'nama' => 'Surat Keterangan Pindah',
                        'deskripsi' => 'Untuk warga yang akan pindah ke luar wilayah desa',
                        'persyaratan' => [
                            'KTP asli',
                            'Kartu Keluarga asli',
                            'Surat pengantar RT/RW',
                            'Alasan pindah',
                        ],
                        'waktu' => '2-3 hari kerja',
                        'biaya' => 'Gratis',
                    ],
                    [
                        'nama' => 'Surat Keterangan Catatan Kepolisian (SKCK)',
                        'deskripsi' => 'Pengantar pembuatan SKCK ke kepolisian setempat',
                        'persyaratan' => [
                            'Fotokopi KTP',
                            'Fotokopi KK',
                            'Pas foto 4x6 (6 lembar)',
                            'Surat pengantar RT/RW',
                        ],
                        'waktu' => '1 hari kerja',
                        'biaya' => 'Gratis',
                    ],
                    [
                        'nama' => 'Surat Pengantar Nikah (N1, N2, N4)',
                        'deskripsi' => 'Pengantar untuk pengurusan pernikahan di KUA atau Catatan Sipil',
                        'persyaratan' => [
                            'KTP calon pengantin',
                            'KK calon pengantin',
                            'Akta kelahiran',
                            'Pas foto 2x3 dan 3x4',
                        ],
                        'waktu' => '1-2 hari kerja',
                        'biaya' => 'Gratis',
                    ],
                ],
                'bantuan_sosial' => [
                    [
                        'nama' => 'Program Keluarga Harapan (PKH)',
                        'penerima' => '142 KPM',
                        'deskripsi' => 'Bantuan sosial bersyarat bagi keluarga miskin dan rentan untuk meningkatkan kualitas kesehatan dan pendidikan',
                    ],
                    [
                        'nama' => 'Bantuan Pangan Non Tunai (BPNT)',
                        'penerima' => '185 KPM',
                        'deskripsi' => 'Bantuan pangan berupa beras, telur, dan kebutuhan pokok lainnya melalui kartu KKS',
                    ],
                    [
                        'nama' => 'Jaminan Kesehatan (PBI-JKN)',
                        'penerima' => '320 jiwa',
                        'deskripsi' => 'Penerima Bantuan Iuran BPJS Kesehatan untuk warga kurang mampu',
                    ],
                    [
                        'nama' => 'Program Indonesia Pintar (PIP)',
                        'penerima' => '95 siswa',
                        'deskripsi' => 'Bantuan biaya pendidikan bagi siswa dari keluarga kurang mampu tingkat SD, SMP, dan SMA',
                    ],
                    [
                        'nama' => 'Bantuan Lansia',
                        'penerima' => '45 orang',
                        'deskripsi' => 'Bantuan dana untuk warga lanjut usia yang tidak memiliki sumber penghasilan tetap',
                    ],
                    [
                        'nama' => 'BLT Dana Desa',
                        'penerima' => '75 KPM',
                        'deskripsi' => 'Bantuan Langsung Tunai dari Dana Desa untuk keluarga miskin dan terdampak',
                    ],
                ],
                'alur_pelayanan' => [
                    'Warga datang ke Kantor Desa dengan membawa persyaratan yang diperlukan',
                    'Menemui petugas pelayanan di loket/meja pelayanan',
                    'Petugas memverifikasi dokumen dan persyaratan',
                    'Proses pembuatan surat oleh perangkat desa',
                    'Penandatanganan oleh Kepala Desa / pejabat berwenang',
                    'Surat selesai dan diserahkan kepada warga',
                ],
                'info_tambahan' => [
                    'gratis' => 'Seluruh layanan administrasi desa GRATIS — tidak dipungut biaya apapun',
                    'jam_pelayanan' => 'Senin - Jumat, 08:00 - 16:00 WIT | Sabtu: 08:00 - 12:00 WIT (terbatas)',
                ],
            ],
            'aktif' => true,
        ]);
        $this->command->info('   ✅ Layanan Publik created');

        $this->command->newLine();
        $this->command->info('🎉 Desa Info Seeder Completed!');
        $this->command->info('📊 Total Data Created: 9 items');
    }
}
