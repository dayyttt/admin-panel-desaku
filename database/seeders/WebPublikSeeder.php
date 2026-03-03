<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WebSlider;
use App\Models\WebArtikel;
use App\Models\WebGaleri;
use App\Models\WebPotensi;
use App\Models\WebTeksBerjalan;
use App\Models\Lapak;
use App\Models\WebHalaman;

class WebPublikSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🌱 Starting Web Publik Seeder...');
        $this->command->newLine();

        // Truncate tables untuk menghindari duplicate
        $this->command->info('🗑️  Truncating existing data...');
        
        // Disable foreign key checks (support MySQL & SQLite)
        if (\DB::getDriverName() === 'mysql') {
            \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        } else {
            \DB::statement('PRAGMA foreign_keys = OFF;');
        }
        
        WebSlider::truncate();
        WebTeksBerjalan::truncate();
        WebArtikel::truncate();
        WebGaleri::truncate();
        WebPotensi::truncate();
        Lapak::truncate();
        WebHalaman::truncate();
        
        // Re-enable foreign key checks
        if (\DB::getDriverName() === 'mysql') {
            \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        } else {
            \DB::statement('PRAGMA foreign_keys = ON;');
        }
        
        $this->command->info('   ✅ Tables truncated');
        $this->command->newLine();

        // 1. SLIDER HERO (3 items)
        $this->command->info('📸 Creating Sliders...');
        $sliders = [
            [
                'judul' => 'Selamat Datang di Desa Lesane',
                'subjudul' => 'Negeri Adat yang Kaya Budaya dan Potensi Bahari di Maluku Tengah',
                'foto_path' => 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=1920',
                'url_aksi' => '/profil',
                'label_tombol' => 'Kenali Desa Kami',
                'aktif' => true,
                'urutan' => 1,
            ],
            [
                'judul' => 'Pantai Lesane yang Memukau',
                'subjudul' => 'Keindahan alam pesisir dengan air laut jernih dan pasir putih yang menawan',
                'foto_path' => 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=1920',
                'url_aksi' => '/potensi',
                'label_tombol' => 'Lihat Potensi',
                'aktif' => true,
                'urutan' => 2,
            ],
            [
                'judul' => 'Budaya Pela Gandong',
                'subjudul' => 'Ikatan persaudaraan yang menjadi kearifan lokal masyarakat Maluku',
                'foto_path' => 'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?w=1920',
                'url_aksi' => '/profil',
                'label_tombol' => 'Pelajari Lebih Lanjut',
                'aktif' => true,
                'urutan' => 3,
            ],
        ];

        foreach ($sliders as $slider) {
            WebSlider::create($slider);
        }
        $this->command->info('   ✅ ' . count($sliders) . ' Sliders created');


        // 2. TEKS BERJALAN (3 items)
        $this->command->info('📢 Creating Teks Berjalan...');
        $teksBerjalan = [
            [
                'teks' => '🎉 Selamat datang di Website Resmi Desa Lesane, Kecamatan Kota Masohi, Kabupaten Maluku Tengah',
                'warna_teks' => '#ffffff',
                'warna_bg' => '#1B5E20',
                'aktif' => true,
                'urutan' => 1,
            ],
            [
                'teks' => '📢 Musrenbangdes 2026 akan dilaksanakan pada tanggal 15 Maret 2026 di Balai Desa',
                'warna_teks' => '#ffffff',
                'warna_bg' => '#0277BD',
                'tanggal_mulai' => now(),
                'tanggal_selesai' => now()->addMonths(1),
                'aktif' => true,
                'urutan' => 2,
            ],
            [
                'teks' => '💰 Transparansi APBDes 2026 dapat diakses melalui menu Statistik',
                'warna_teks' => '#ffffff',
                'warna_bg' => '#E65100',
                'aktif' => true,
                'urutan' => 3,
            ],
        ];

        foreach ($teksBerjalan as $teks) {
            WebTeksBerjalan::create($teks);
        }
        $this->command->info('   ✅ ' . count($teksBerjalan) . ' Teks Berjalan created');


        // 3. ARTIKEL/BERITA (8 items)
        $this->command->info('📰 Creating Artikel...');
        $artikel = [
            [
                'judul' => 'Musrenbangdes 2026: Prioritas Pembangunan Infrastruktur Jalan Desa',
                'slug' => 'musrenbangdes-2026-prioritas-pembangunan-infrastruktur',
                'kategori' => 'berita',
                'konten' => '<p>Pemerintah Desa Lesane mengadakan Musyawarah Perencanaan Pembangunan Desa (Musrenbangdes) tahun 2026 dengan fokus utama pada perbaikan infrastruktur jalan desa sepanjang 3,5 km yang menghubungkan dusun-dusun.</p><p>Musrenbangdes dihadiri oleh seluruh perangkat desa, BPD, tokoh masyarakat, dan perwakilan dari setiap RT/RW. Dalam musyawarah tersebut, disepakati beberapa program prioritas pembangunan desa untuk tahun 2026.</p><p>Kepala Desa Lesane, Muhammad Saleh Lestaluhu, menyampaikan bahwa perbaikan jalan desa menjadi prioritas utama karena kondisi jalan yang rusak menghambat aktivitas ekonomi masyarakat, terutama para petani dan nelayan dalam mengangkut hasil panen dan tangkapan.</p>',
                'ringkasan' => 'Pemerintah Desa Lesane mengadakan Musrenbangdes 2026 dengan fokus utama pada perbaikan infrastruktur jalan desa sepanjang 3,5 km.',
                'thumbnail' => 'https://images.unsplash.com/photo-1511632765486-a01980e01a18?w=800',
                'publish' => true,
                'published_at' => now()->subDays(2),
                'view_count' => 156,
            ],
            [
                'judul' => 'Program Pemberdayaan Nelayan Melalui Bantuan Alat Tangkap Modern',
                'slug' => 'program-pemberdayaan-nelayan-bantuan-alat-tangkap',
                'kategori' => 'berita',
                'konten' => '<p>Dinas Perikanan Kabupaten Maluku Tengah bekerja sama dengan Pemerintah Desa Lesane menyalurkan bantuan 25 unit alat tangkap modern kepada kelompok nelayan desa pada Senin (25/2/2026).</p><p>Program bantuan alat tangkap ini bertujuan untuk meningkatkan produktivitas dan pendapatan nelayan Desa Lesane. Alat tangkap yang diberikan berupa jaring insang, pancing tonda, dan bubu lipat yang lebih efisien dibandingkan alat tradisional.</p><p>Ketua Kelompok Nelayan Lesane, Bapak Ibrahim Tuasikal, menyampaikan terima kasih atas bantuan ini dan berharap dapat meningkatkan hasil tangkapan hingga 40% dalam 6 bulan ke depan.</p>',
                'ringkasan' => 'Dinas Perikanan menyalurkan bantuan 25 unit alat tangkap modern kepada kelompok nelayan Desa Lesane.',
                'thumbnail' => 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=800',
                'publish' => true,
                'published_at' => now()->subDays(5),
                'view_count' => 203,
            ],
            [
                'judul' => 'Festival Budaya Pela Gandong: Mempererat Persaudaraan Antar Negeri',
                'slug' => 'festival-budaya-pela-gandong-persaudaraan-antar-negeri',
                'kategori' => 'artikel',
                'konten' => '<p>Desa Lesane menjadi tuan rumah Festival Budaya Pela Gandong yang diikuti oleh 8 negeri se-Kecamatan Kota Masohi dengan menampilkan berbagai kesenian tradisional pada 18-20 Februari 2026.</p><p>Festival berlangsung selama 3 hari dan menampilkan tarian Cakalele, musik Totobuang, lomba perahu tradisional, serta pameran kuliner khas Maluku. Acara dibuka oleh Bupati Maluku Tengah dan dihadiri ribuan pengunjung dari berbagai daerah.</p><p>Pela Gandong adalah ikatan persaudaraan antar negeri di Maluku yang telah ada sejak ratusan tahun lalu. Festival ini menjadi wadah untuk melestarikan nilai-nilai budaya dan mempererat tali persaudaraan.</p>',
                'ringkasan' => 'Desa Lesane menjadi tuan rumah Festival Budaya Pela Gandong yang diikuti oleh 8 negeri dengan berbagai kesenian tradisional.',
                'thumbnail' => 'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?w=800',
                'publish' => true,
                'published_at' => now()->subDays(7),
                'view_count' => 342,
            ],
            [
                'judul' => 'Posyandu Desa Lesane Raih Penghargaan Tingkat Kabupaten',
                'slug' => 'posyandu-desa-lesane-raih-penghargaan',
                'kategori' => 'pengumuman',
                'konten' => '<p>Posyandu Melati Desa Lesane berhasil meraih penghargaan sebagai Posyandu terbaik tingkat Kabupaten Maluku Tengah tahun 2025 berkat pelayanan kesehatan yang prima kepada ibu hamil, ibu menyusui, dan balita.</p><p>Penghargaan diserahkan langsung oleh Bupati Maluku Tengah dalam acara Hari Kesehatan Nasional di Masohi. Posyandu Melati dinilai unggul dalam hal cakupan pelayanan, kelengkapan data, dan inovasi program kesehatan.</p>',
                'ringkasan' => 'Posyandu Melati Desa Lesane raih penghargaan Posyandu terbaik tingkat Kabupaten Maluku Tengah 2025.',
                'thumbnail' => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=800',
                'publish' => true,
                'published_at' => now()->subDays(10),
                'view_count' => 189,
            ],
            [
                'judul' => 'Pelatihan Digital Marketing untuk UMKM Desa Lesane',
                'slug' => 'pelatihan-digital-marketing-umkm-desa-lesane',
                'kategori' => 'berita',
                'konten' => '<p>Sebanyak 40 pelaku UMKM Desa Lesane mengikuti pelatihan digital marketing yang diselenggarakan oleh Dinas Koperasi dan UMKM Kabupaten Maluku Tengah bekerja sama dengan Pemerintah Desa pada 10-12 Februari 2026.</p><p>Pelatihan ini bertujuan untuk meningkatkan kemampuan pelaku UMKM dalam memasarkan produk lokal secara online melalui marketplace seperti Tokopedia, Shopee, dan media sosial seperti Instagram dan Facebook.</p><p>Materi pelatihan meliputi fotografi produk, copywriting, strategi promosi online, dan pengelolaan toko online. Peserta juga mendapat pendampingan untuk membuat akun bisnis dan mengunggah produk pertama mereka.</p>',
                'ringkasan' => '40 pelaku UMKM Desa Lesane mengikuti pelatihan digital marketing untuk memasarkan produk lokal secara online.',
                'thumbnail' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800',
                'publish' => true,
                'published_at' => now()->subDays(12),
                'view_count' => 167,
            ],
            [
                'judul' => 'Rehabilitasi Kawasan Mangrove Pesisir Desa Lesane',
                'slug' => 'rehabilitasi-kawasan-mangrove-pesisir-desa-lesane',
                'kategori' => 'artikel',
                'konten' => '<p>Pemerintah Desa Lesane bersama komunitas pemuda dan LSM lingkungan melakukan penanaman 5.000 bibit mangrove di kawasan pesisir desa yang mengalami abrasi pada Minggu (5/2/2026).</p><p>Kegiatan ini merupakan bagian dari program rehabilitasi kawasan pesisir yang didanai oleh APBDes dan bantuan dari Kementerian Lingkungan Hidup. Penanaman mangrove bertujuan untuk mencegah abrasi pantai dan melestarikan ekosistem pesisir.</p><p>Kepala Desa menyampaikan bahwa program ini akan dilanjutkan setiap tahun dengan target penanaman 10.000 bibit mangrove hingga tahun 2028.</p>',
                'ringkasan' => 'Penanaman 5.000 bibit mangrove di kawasan pesisir Desa Lesane untuk mencegah abrasi dan melestarikan lingkungan.',
                'thumbnail' => 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?w=800',
                'publish' => true,
                'published_at' => now()->subDays(15),
                'view_count' => 234,
            ],
            [
                'judul' => 'Pembangunan Dermaga Nelayan Tahap II Dimulai',
                'slug' => 'pembangunan-dermaga-nelayan-tahap-ii-dimulai',
                'kategori' => 'berita',
                'konten' => '<p>Pembangunan dermaga nelayan tahap II di Desa Lesane resmi dimulai pada Kamis (1/2/2026) dengan nilai kontrak Rp 850 juta yang bersumber dari Dana Desa dan APBD Kabupaten.</p><p>Dermaga sepanjang 75 meter ini akan dilengkapi dengan fasilitas cold storage, tempat pelelangan ikan, dan area parkir perahu. Pembangunan ditargetkan selesai dalam 6 bulan.</p>',
                'ringkasan' => 'Pembangunan dermaga nelayan tahap II senilai Rp 850 juta dimulai dengan target selesai dalam 6 bulan.',
                'thumbnail' => 'https://images.unsplash.com/photo-1605647540924-852290f6b0d5?w=800',
                'publish' => true,
                'published_at' => now()->subDays(20),
                'view_count' => 198,
            ],
            [
                'judul' => 'Lomba Desa Tingkat Provinsi: Lesane Masuk 10 Besar',
                'slug' => 'lomba-desa-tingkat-provinsi-lesane-masuk-10-besar',
                'kategori' => 'pengumuman',
                'konten' => '<p>Desa Lesane berhasil masuk 10 besar dalam Lomba Desa tingkat Provinsi Maluku tahun 2025 kategori Desa Mandiri. Penilaian dilakukan berdasarkan aspek tata kelola pemerintahan, pembangunan infrastruktur, pemberdayaan masyarakat, dan pelestarian lingkungan.</p><p>Pencapaian ini merupakan hasil kerja keras seluruh elemen masyarakat dan pemerintah desa dalam membangun Desa Lesane menjadi desa yang maju dan mandiri.</p>',
                'ringkasan' => 'Desa Lesane masuk 10 besar Lomba Desa tingkat Provinsi Maluku 2025 kategori Desa Mandiri.',
                'thumbnail' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?w=800',
                'publish' => true,
                'published_at' => now()->subDays(25),
                'view_count' => 276,
            ],
        ];

        foreach ($artikel as $art) {
            WebArtikel::create($art);
        }
        $this->command->info('   ✅ ' . count($artikel) . ' Artikel created');


        // 4. GALERI (7 items)
        $this->command->info('🖼️  Creating Galeri...');
        $galeri = [
            [
                'judul' => 'Pantai Lesane Saat Senja',
                'deskripsi' => 'Pemandangan matahari terbenam yang memukau dari Pantai Lesane dengan siluet perahu nelayan tradisional',
                'tipe' => 'foto',
                'file_path' => 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=800',
                'tanggal_kegiatan' => now()->subDays(5),
                'lokasi_kegiatan' => 'Pantai Lesane',
                'publish' => true,
                'urutan' => 1,
            ],
            [
                'judul' => 'Tarian Cakalele Festival Budaya',
                'deskripsi' => 'Pertunjukan tarian perang tradisional Cakalele dalam Festival Budaya Pela Gandong',
                'tipe' => 'foto',
                'file_path' => 'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?w=800',
                'tanggal_kegiatan' => now()->subDays(7),
                'lokasi_kegiatan' => 'Balai Desa Lesane',
                'publish' => true,
                'urutan' => 2,
            ],
            [
                'judul' => 'Musrenbangdes 2026',
                'deskripsi' => 'Suasana Musyawarah Perencanaan Pembangunan Desa yang dihadiri seluruh lapisan masyarakat',
                'tipe' => 'foto',
                'file_path' => 'https://images.unsplash.com/photo-1511632765486-a01980e01a18?w=800',
                'tanggal_kegiatan' => now()->subDays(2),
                'lokasi_kegiatan' => 'Balai Desa Lesane',
                'publish' => true,
                'urutan' => 3,
            ],
            [
                'judul' => 'Penanaman Mangrove',
                'deskripsi' => 'Aksi kolaboratif penanaman 5.000 bibit mangrove oleh pemuda desa bersama LSM lingkungan',
                'tipe' => 'foto',
                'file_path' => 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?w=800',
                'tanggal_kegiatan' => now()->subDays(15),
                'lokasi_kegiatan' => 'Pesisir Desa Lesane',
                'publish' => true,
                'urutan' => 4,
            ],
            [
                'judul' => 'Penyerahan Bantuan Alat Tangkap',
                'deskripsi' => 'Momen penyerahan bantuan 25 unit alat tangkap modern kepada kelompok nelayan',
                'tipe' => 'foto',
                'file_path' => 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=800',
                'tanggal_kegiatan' => now()->subDays(5),
                'lokasi_kegiatan' => 'Dermaga Nelayan Lesane',
                'publish' => true,
                'urutan' => 5,
            ],
            [
                'judul' => 'Profil Desa Lesane',
                'deskripsi' => 'Video profil Desa Lesane yang menampilkan keindahan alam, budaya, dan potensi desa',
                'tipe' => 'video',
                'url_video' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'thumbnail' => 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=800',
                'tanggal_kegiatan' => now()->subDays(30),
                'publish' => true,
                'urutan' => 6,
            ],
            [
                'judul' => 'Festival Pela Gandong 2026',
                'deskripsi' => 'Highlight Festival Budaya Pela Gandong dengan berbagai pertunjukan seni tradisional',
                'tipe' => 'video',
                'url_video' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'thumbnail' => 'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?w=800',
                'tanggal_kegiatan' => now()->subDays(7),
                'publish' => true,
                'urutan' => 7,
            ],
        ];

        foreach ($galeri as $gal) {
            WebGaleri::create($gal);
        }
        $this->command->info('   ✅ ' . count($galeri) . ' Galeri created');


        // 5. POTENSI DESA (8 items)
        $this->command->info('⭐ Creating Potensi...');
        $potensi = [
            [
                'judul' => 'Pantai Lesane',
                'kategori' => 'wisata',
                'deskripsi' => '<p>Pantai berpasir putih dengan air laut jernih dan pemandangan Teluk Masohi yang memukau. Cocok untuk berenang, snorkeling, dan menikmati sunset.</p><p>Fasilitas: Gazebo, toilet, warung makan, area parkir.</p>',
                'foto' => json_encode(['https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=800']),
                'kontak' => '081234567890',
                'latitude' => '-3.3950',
                'longitude' => '128.9050',
                'publish' => true,
                'urutan' => 1,
            ],
            [
                'judul' => 'Perkebunan Cengkeh',
                'kategori' => 'pertanian',
                'deskripsi' => '<p>Perkebunan cengkeh yang luas dan subur, komoditas andalan masyarakat Desa Lesane sejak zaman kolonial. Produksi mencapai 45 ton per tahun dengan kualitas premium.</p><p>Cengkeh Lesane terkenal karena aromanya yang khas dan kadar minyak atsiri yang tinggi.</p>',
                'foto' => json_encode(['https://images.unsplash.com/photo-1464226184884-fa280b87c399?w=800']),
                'publish' => true,
                'urutan' => 2,
            ],
            [
                'judul' => 'Perikanan Tangkap',
                'kategori' => 'perikanan',
                'deskripsi' => '<p>Hasil tangkapan utama nelayan Lesane dari perairan Laut Banda meliputi tuna, cakalang, tongkol, dan berbagai jenis ikan laut lainnya.</p><p>Desa Lesane memiliki 120 nelayan aktif dengan 45 perahu motor dan 30 perahu tradisional.</p>',
                'foto' => json_encode(['https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=800']),
                'kontak' => '081234567891',
                'publish' => true,
                'urutan' => 3,
            ],
            [
                'judul' => 'Hutan Mangrove',
                'kategori' => 'wisata',
                'deskripsi' => '<p>Kawasan hutan bakau yang masih lestari di pesisir selatan Desa Lesane, habitat berbagai jenis burung dan biota laut. Tersedia jalur tracking kayu sepanjang 500 meter.</p><p>Cocok untuk wisata edukasi lingkungan dan bird watching.</p>',
                'foto' => json_encode(['https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?w=800']),
                'latitude' => '-3.3960',
                'longitude' => '128.9040',
                'publish' => true,
                'urutan' => 4,
            ],
            [
                'judul' => 'Tarian Cakalele',
                'kategori' => 'budaya',
                'deskripsi' => '<p>Tarian perang tradisional yang gagah dan penuh semangat, menjadi warisan budaya yang masih dilestarikan oleh masyarakat Desa Lesane.</p><p>Tarian ini biasanya ditampilkan dalam acara adat, penyambutan tamu penting, dan festival budaya.</p>',
                'foto' => json_encode(['https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?w=800']),
                'publish' => true,
                'urutan' => 5,
            ],
            [
                'judul' => 'Budidaya Rumput Laut',
                'kategori' => 'perikanan',
                'deskripsi' => '<p>Budidaya rumput laut jenis Eucheuma cottonii dengan metode long line di perairan pesisir. Produksi mencapai 15 ton per bulan dalam kondisi kering.</p><p>Rumput laut Lesane diekspor ke berbagai daerah untuk industri makanan dan kosmetik.</p>',
                'foto' => json_encode(['https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=800']),
                'kontak' => '081234567892',
                'publish' => true,
                'urutan' => 6,
            ],
            [
                'judul' => 'Kerajinan Anyaman Bambu',
                'kategori' => 'kerajinan',
                'deskripsi' => '<p>Kerajinan anyaman bambu dengan motif tradisional Maluku yang dibuat oleh pengrajin lokal. Produk meliputi tas, tempat nasi, hiasan dinding, dan furniture.</p><p>Kerajinan ini telah dipasarkan hingga ke luar daerah dan menjadi oleh-oleh khas Desa Lesane.</p>',
                'foto' => json_encode(['https://images.unsplash.com/photo-1610701596007-11502861dcfa?w=800']),
                'kontak' => '081234567893',
                'publish' => true,
                'urutan' => 7,
            ],
            [
                'judul' => 'Kuliner Ikan Asap',
                'kategori' => 'kuliner',
                'deskripsi' => '<p>Ikan asap khas Maluku dengan cita rasa yang unik dan tahan lama. Dibuat dari ikan cakalang, tuna, atau tongkol yang diasap dengan kayu khusus.</p><p>Ikan asap Lesane terkenal karena teksturnya yang pas dan aroma asap yang tidak terlalu kuat.</p>',
                'foto' => json_encode(['https://images.unsplash.com/photo-1599084993091-1cb5c0721cc6?w=800']),
                'kontak' => '081234567894',
                'publish' => true,
                'urutan' => 8,
            ],
        ];

        foreach ($potensi as $pot) {
            WebPotensi::create($pot);
        }
        $this->command->info('   ✅ ' . count($potensi) . ' Potensi created');


        // 6. LAPAK UMKM (6 items)
        $this->command->info('🏪 Creating Lapak UMKM...');
        $lapak = [
            [
                'nama_usaha' => 'Warung Makan Bu Siti',
                'slug' => 'warung-makan-bu-siti',
                'kategori' => 'kuliner',
                'deskripsi' => '<p>Warung makan dengan menu masakan khas Maluku. Spesialisasi ikan bakar, papeda, dan kohu-kohu. Buka setiap hari dari pukul 08.00 - 20.00 WIT.</p><p>Menu favorit: Ikan Bakar Rica-Rica, Papeda Kuah Kuning, Kohu-Kohu Ikan Tuna.</p>',
                'nama_pemilik' => 'Siti Aminah',
                'telepon' => '081234567890',
                'whatsapp' => '6281234567890',
                'alamat' => 'Jl. Raya Lesane No. 15, RT 02',
                'foto_usaha' => 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=800',
                'foto_lainnya' => json_encode([
                    'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=800',
                    'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=800',
                ]),
                'latitude' => '-3.3950',
                'longitude' => '128.9050',
                'publish' => true,
                'aktif' => true,
            ],
            [
                'nama_usaha' => 'Kerajinan Anyaman Bambu Pak Umar',
                'slug' => 'kerajinan-anyaman-bambu-pak-umar',
                'kategori' => 'kerajinan',
                'deskripsi' => '<p>Memproduksi berbagai kerajinan anyaman bambu seperti bakul, tampah, kipas, dan hiasan dinding. Menerima pesanan custom sesuai kebutuhan.</p><p>Produk unggulan: Tas Anyaman Motif Maluku, Tempat Nasi Tradisional, Hiasan Dinding Etnik.</p>',
                'nama_pemilik' => 'Umar Latuconsina',
                'telepon' => '082345678901',
                'whatsapp' => '6282345678901',
                'alamat' => 'Jl. Pattimura No. 8, RT 01',
                'foto_usaha' => 'https://images.unsplash.com/photo-1610701596007-11502861dcfa?w=800',
                'foto_lainnya' => json_encode([
                    'https://images.unsplash.com/photo-1565193566173-7a0ee3dbe261?w=800',
                ]),
                'latitude' => '-3.3955',
                'longitude' => '128.9045',
                'publish' => true,
                'aktif' => true,
            ],
            [
                'nama_usaha' => 'Ikan Asap & Abon Ikan Ibu Fatimah',
                'slug' => 'ikan-asap-abon-ikan-ibu-fatimah',
                'kategori' => 'perikanan',
                'deskripsi' => '<p>Produsen ikan asap dan abon ikan berkualitas dari hasil tangkapan nelayan lokal. Tersedia ikan cakalang asap, tuna asap, dan abon ikan dalam kemasan praktis.</p><p>Produk tahan hingga 3 bulan tanpa pengawet. Cocok untuk oleh-oleh.</p>',
                'nama_pemilik' => 'Fatimah Tuasikal',
                'telepon' => '083456789012',
                'whatsapp' => '6283456789012',
                'alamat' => 'Jl. Pelabuhan No. 22, RT 03',
                'foto_usaha' => 'https://images.unsplash.com/photo-1599084993091-1cb5c0721cc6?w=800',
                'foto_lainnya' => json_encode([
                    'https://images.unsplash.com/photo-1580959375944-0b7b2e7e5b5e?w=800',
                ]),
                'latitude' => '-3.3945',
                'longitude' => '128.9055',
                'publish' => true,
                'aktif' => true,
            ],
            [
                'nama_usaha' => 'Kopi Lesane',
                'slug' => 'kopi-lesane',
                'kategori' => 'kuliner',
                'deskripsi' => '<p>Kopi robusta lokal dengan aroma khas dan rasa yang nikmat. Tersedia dalam bentuk biji dan bubuk. Proses roasting menggunakan metode tradisional.</p><p>Varian: Original, Medium Roast, Dark Roast. Kemasan 250gr dan 500gr.</p>',
                'nama_pemilik' => 'Ibrahim Rehatta',
                'telepon' => '084567890123',
                'whatsapp' => '6284567890123',
                'alamat' => 'Jl. Raya Lesane No. 45, RT 04',
                'foto_usaha' => 'https://images.unsplash.com/photo-1447933601403-0c6688de566e?w=800',
                'latitude' => '-3.3948',
                'longitude' => '128.9052',
                'publish' => true,
                'aktif' => true,
            ],
            [
                'nama_usaha' => 'Rumput Laut Kering Bu Aisyah',
                'slug' => 'rumput-laut-kering-bu-aisyah',
                'kategori' => 'pertanian',
                'deskripsi' => '<p>Rumput laut kering jenis Eucheuma cottonii berkualitas ekspor. Proses pengeringan higienis dengan standar food grade.</p><p>Tersedia dalam kemasan 1kg, 5kg, dan 10kg. Melayani pembelian partai besar.</p>',
                'nama_pemilik' => 'Aisyah Wattimena',
                'telepon' => '085678901234',
                'whatsapp' => '6285678901234',
                'alamat' => 'Jl. Pantai No. 12, RT 05',
                'foto_usaha' => 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=800',
                'latitude' => '-3.3952',
                'longitude' => '128.9048',
                'publish' => true,
                'aktif' => true,
            ],
            [
                'nama_usaha' => 'Jasa Tur Wisata Lesane',
                'slug' => 'jasa-tur-wisata-lesane',
                'kategori' => 'jasa',
                'deskripsi' => '<p>Jasa pemandu wisata lokal untuk menjelajahi keindahan Desa Lesane. Paket wisata meliputi: pantai, mangrove, snorkeling, dan wisata budaya.</p><p>Tersedia paket half day dan full day. Termasuk transportasi, makan, dan dokumentasi.</p>',
                'nama_pemilik' => 'Yusuf Lestaluhu',
                'telepon' => '086789012345',
                'whatsapp' => '6286789012345',
                'alamat' => 'Jl. Raya Lesane No. 30, RT 02',
                'foto_usaha' => 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=800',
                'latitude' => '-3.3950',
                'longitude' => '128.9050',
                'publish' => true,
                'aktif' => true,
            ],
            [
                'nama_usaha' => 'Batik & Tenun Ibu Rahma',
                'slug' => 'batik-tenun-ibu-rahma',
                'kategori' => 'fashion',
                'deskripsi' => '<p>Menjual kain batik dan tenun khas Maluku dengan motif tradisional yang indah. Tersedia kain, kemeja, dress, dan aksesoris fashion lainnya.</p><p>Produk unggulan: Kain Tenun Ikat Maluku, Kemeja Batik Motif Pala, Dress Tenun Modern. Menerima pesanan custom dan jahit sesuai ukuran.</p>',
                'nama_pemilik' => 'Rahma Sahetapy',
                'telepon' => '087890123456',
                'whatsapp' => '6287890123456',
                'alamat' => 'Jl. Pattimura No. 25, RT 03',
                'foto_usaha' => 'https://images.unsplash.com/photo-1610652492500-ded49ceeb378?w=800',
                'foto_lainnya' => json_encode([
                    'https://images.unsplash.com/photo-1610701596007-11502861dcfa?w=800',
                    'https://images.unsplash.com/photo-1622519407650-3df9883f76e5?w=800',
                ]),
                'latitude' => '-3.3953',
                'longitude' => '128.9047',
                'publish' => true,
                'aktif' => true,
            ],
            [
                'nama_usaha' => 'Bengkel Motor Pak Hasan',
                'slug' => 'bengkel-motor-pak-hasan',
                'kategori' => 'lainnya',
                'deskripsi' => '<p>Bengkel motor yang melayani servis rutin, perbaikan mesin, ganti oli, dan spare part. Berpengalaman lebih dari 15 tahun dengan mekanik yang handal.</p><p>Melayani semua jenis motor. Harga terjangkau dan garansi perbaikan. Buka Senin-Sabtu pukul 08.00-17.00 WIT.</p>',
                'nama_pemilik' => 'Hasan Marasabessy',
                'telepon' => '088901234567',
                'whatsapp' => '6288901234567',
                'alamat' => 'Jl. Raya Lesane No. 52, RT 04',
                'foto_usaha' => 'https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?w=800',
                'latitude' => '-3.3947',
                'longitude' => '128.9053',
                'publish' => true,
                'aktif' => true,
            ],
        ];

        foreach ($lapak as $lap) {
            Lapak::create($lap);
        }
        $this->command->info('   ✅ ' . count($lapak) . ' Lapak UMKM created');


        // 7. HALAMAN STATIS (3 items)
        $this->command->info('📄 Creating Halaman Statis...');
        $halaman = [
            [
                'judul' => 'Tentang Kami',
                'slug' => 'tentang-kami',
                'konten' => '<h2>Tentang Website Desa Lesane</h2><p>Website ini merupakan portal resmi Pemerintah Desa Lesane yang bertujuan untuk memberikan informasi terkini tentang desa, pelayanan publik, dan transparansi pemerintahan kepada masyarakat.</p><h3>Visi Website</h3><p>Menjadi media informasi dan komunikasi yang efektif antara pemerintah desa dengan masyarakat dalam rangka mewujudkan tata kelola pemerintahan yang baik, transparan, dan akuntabel.</p><h3>Fitur Website</h3><ul><li>Informasi profil desa lengkap</li><li>Berita dan kegiatan desa terkini</li><li>Galeri foto dan video</li><li>Data statistik kependudukan</li><li>Transparansi keuangan desa</li><li>Informasi potensi dan UMKM desa</li></ul>',
                'tampil_menu' => true,
                'urutan' => 1,
                'ikon' => 'heroicon-o-information-circle',
                'publish' => true,
            ],
            [
                'judul' => 'Kontak Kami',
                'slug' => 'kontak-kami',
                'konten' => '<h2>Hubungi Kami</h2><p>Untuk informasi lebih lanjut atau pertanyaan seputar Desa Lesane, silakan hubungi kami melalui:</p><h3>Kantor Desa Lesane</h3><p><strong>Alamat:</strong><br>Jl. Raya Lesane No. 1<br>Desa Lesane, Kecamatan Kota Masohi<br>Kabupaten Maluku Tengah, Provinsi Maluku<br>Kode Pos: 97511</p><p><strong>Telepon:</strong> (0914) 123456<br><strong>Email:</strong> pemdes.lesane@gmail.com<br><strong>Website:</strong> www.desalesane.id</p><h3>Jam Pelayanan</h3><p>Senin - Jumat: 08.00 - 15.00 WIT<br>Sabtu: 08.00 - 12.00 WIT<br>Minggu & Hari Libur: Tutup</p>',
                'tampil_menu' => true,
                'urutan' => 2,
                'ikon' => 'heroicon-o-phone',
                'publish' => true,
            ],
            [
                'judul' => 'Kebijakan Privasi',
                'slug' => 'kebijakan-privasi',
                'konten' => '<h2>Kebijakan Privasi</h2><p>Pemerintah Desa Lesane menghormati privasi pengunjung website ini. Kebijakan privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi informasi pribadi Anda.</p><h3>Informasi yang Kami Kumpulkan</h3><p>Kami dapat mengumpulkan informasi berikut:</p><ul><li>Informasi yang Anda berikan saat mengisi formulir kontak</li><li>Data penggunaan website melalui cookies</li><li>Alamat IP dan informasi browser</li></ul><h3>Penggunaan Informasi</h3><p>Informasi yang kami kumpulkan digunakan untuk:</p><ul><li>Meningkatkan layanan website</li><li>Merespons pertanyaan dan permintaan Anda</li><li>Mengirimkan informasi yang Anda minta</li><li>Analisis statistik penggunaan website</li></ul><h3>Keamanan Data</h3><p>Kami berkomitmen untuk melindungi informasi pribadi Anda dan menggunakan langkah-langkah keamanan yang sesuai untuk mencegah akses, penggunaan, atau pengungkapan yang tidak sah.</p>',
                'tampil_menu' => false,
                'urutan' => 3,
                'publish' => true,
            ],
        ];

        foreach ($halaman as $hal) {
            WebHalaman::create($hal);
        }
        $this->command->info('   ✅ ' . count($halaman) . ' Halaman Statis created');

        $this->command->newLine();
        $this->command->info('🎉 Web Publik Seeder Completed!');
        $this->command->info('📊 Total Data Created:');
        $this->command->table(
            ['Kategori', 'Jumlah'],
            [
                ['Slider Hero', count($sliders)],
                ['Teks Berjalan', count($teksBerjalan)],
                ['Artikel/Berita', count($artikel)],
                ['Galeri', count($galeri)],
                ['Potensi Desa', count($potensi)],
                ['Lapak UMKM', count($lapak)],
                ['Halaman Statis', count($halaman)],
                ['TOTAL', count($sliders) + count($teksBerjalan) + count($artikel) + count($galeri) + count($potensi) + count($lapak) + count($halaman)],
            ]
        );
    }
}
