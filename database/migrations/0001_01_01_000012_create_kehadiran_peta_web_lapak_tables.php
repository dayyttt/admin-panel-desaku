<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // ── KEHADIRAN PERANGKAT DESA ─────────────────────────────────
        Schema::create('kehadiran_jam_kerja', function (Blueprint $table) {
            $table->id();
            $table->enum('hari', ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu']);
            $table->time('jam_masuk');
            $table->time('jam_istirahat_mulai')->nullable();
            $table->time('jam_istirahat_selesai')->nullable();
            $table->time('jam_pulang');
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        Schema::create('kehadiran_hari_libur', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('keterangan');
            $table->enum('jenis', ['libur_nasional', 'libur_khusus', 'cuti_bersama'])->default('libur_nasional');
            $table->timestamps();

            $table->index('tanggal');
        });

        Schema::create('kehadiran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('perangkat_id')->comment('FK ke perangkat_desa');
            $table->date('tanggal');
            $table->enum('status', ['hadir', 'izin', 'sakit', 'cuti', 'alpha', 'dinas_luar'])->default('hadir');
            $table->time('jam_masuk_aktual')->nullable();
            $table->time('jam_pulang_aktual')->nullable();
            $table->integer('telat_menit')->default(0);
            $table->string('keterangan')->nullable();
            $table->string('bukti_path')->nullable();
            $table->unsignedBigInteger('diinput_oleh')->nullable();
            $table->timestamps();

            $table->foreign('perangkat_id')->references('id')->on('perangkat_desa')->onDelete('cascade');
            $table->unique(['perangkat_id', 'tanggal']);
            $table->index('tanggal');
        });

        Schema::create('kehadiran_pengaduan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('perangkat_id');
            $table->date('tanggal');
            $table->enum('jenis', ['izin', 'sakit', 'cuti', 'dinas_luar']);
            $table->text('alasan');
            $table->string('bukti_path')->nullable();
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak'])->default('menunggu');
            $table->unsignedBigInteger('disetujui_oleh')->nullable();
            $table->timestamp('disetujui_at')->nullable();
            $table->timestamps();

            $table->foreign('perangkat_id')->references('id')->on('perangkat_desa')->onDelete('cascade');
        });

        // ── PETA GIS ─────────────────────────────────────────────────
        Schema::create('peta_wilayah', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wilayah_id')->nullable();
            $table->string('nama');
            $table->enum('tipe', ['desa', 'dusun', 'rw', 'rt'])->default('desa');
            $table->longText('geojson')->comment('GeoJSON Polygon batas wilayah');
            $table->string('warna')->default('#3388ff');
            $table->decimal('opacity', 3, 2)->default(0.5);
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('wilayah_id')->references('id')->on('wilayah')->nullOnDelete();
        });

        Schema::create('peta_lokasi', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kategori')->comment('kantor, sekolah, puskesmas, ibadah, jembatan, dll');
            $table->text('deskripsi')->nullable();
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->string('foto')->nullable();
            $table->string('ikon')->nullable()->comment('Icon marker Leaflet');
            $table->string('warna_ikon')->default('#e74c3c');
            $table->boolean('tampil_publik')->default(true);
            $table->boolean('aktif')->default(true);
            $table->timestamps();

            $table->index('kategori');
        });

        Schema::create('peta_area', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kategori')->comment('sawah, kebun, hutan, pemukiman, dll');
            $table->text('deskripsi')->nullable();
            $table->longText('geojson')->comment('GeoJSON Polygon area kustom');
            $table->decimal('luas_ha', 12, 4)->nullable();
            $table->string('warna')->default('#2ecc71');
            $table->decimal('opacity', 3, 2)->default(0.4);
            $table->boolean('tampil_publik')->default(true);
            $table->timestamps();
        });

        Schema::create('peta_garis', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kategori')->comment('jalan_desa, sungai, irigasi, batas, dll');
            $table->text('deskripsi')->nullable();
            $table->longText('geojson')->comment('GeoJSON LineString / MultiLineString');
            $table->decimal('panjang_km', 10, 3)->nullable();
            $table->string('warna')->default('#3498db');
            $table->integer('ketebalan')->default(3);
            $table->boolean('tampil_publik')->default(true);
            $table->timestamps();
        });

        Schema::create('tanah_persil', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_persil')->nullable();
            $table->string('nama_pemilik')->nullable();
            $table->string('nik_pemilik', 16)->nullable();
            $table->longText('geojson')->comment('GeoJSON Polygon kavling tanah');
            $table->decimal('luas_m2', 12, 2)->nullable();
            $table->string('jenis_tanah')->nullable()->comment('sawah, darat, tambak, dll');
            $table->string('status_kepemilikan')->nullable()->comment('hak_milik, hak_guna, tanah_kas_desa');
            $table->string('nomor_sertifikat')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        // ── WEB DESA ─────────────────────────────────────────────────
        Schema::create('web_artikel', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->enum('kategori', ['berita', 'pengumuman', 'artikel', 'agenda'])->default('berita');
            $table->longText('konten');
            $table->text('ringkasan')->nullable();
            $table->string('thumbnail')->nullable();
            $table->json('gambar_galeri')->nullable();
            $table->boolean('publish')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->integer('view_count')->default(0);
            $table->unsignedBigInteger('dibuat_oleh')->nullable();
            $table->timestamps();

            $table->index(['kategori', 'publish', 'published_at']);
            $table->fullText(['judul', 'konten']);
        });

        Schema::create('web_galeri', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->enum('tipe', ['foto', 'video'])->default('foto');
            $table->string('file_path')->nullable()->comment('Untuk foto');
            $table->string('url_video')->nullable()->comment('YouTube/link untuk video');
            $table->string('thumbnail')->nullable();
            $table->date('tanggal_kegiatan')->nullable();
            $table->string('lokasi_kegiatan')->nullable();
            $table->boolean('publish')->default(true);
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });

        Schema::create('web_halaman', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->longText('konten');
            $table->string('ikon')->nullable();
            $table->boolean('publish')->default(true);
            $table->boolean('tampil_menu')->default(false);
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });

        Schema::create('web_idm', function (Blueprint $table) {
            $table->id();
            $table->year('tahun');
            $table->decimal('skor_ike', 6, 4)->nullable()->comment('Indeks Ketahanan Ekonomi');
            $table->decimal('skor_iks', 6, 4)->nullable()->comment('Indeks Ketahanan Sosial');
            $table->decimal('skor_ikg', 6, 4)->nullable()->comment('Indeks Ketahanan Lingkungan/Ekologi');
            $table->decimal('skor_idm', 6, 4)->nullable()->comment('Total = (IKE+IKS+IKG)/3');
            $table->string('status')->nullable()->comment('Sangat Tertinggal, Tertinggal, Berkembang, Maju, Mandiri');
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->unique('tahun');
        });

        Schema::create('web_potensi', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('kategori')->comment('wisata, pertanian, perikanan, umkm, budaya, dll');
            $table->longText('deskripsi');
            $table->json('foto')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('kontak')->nullable();
            $table->boolean('publish')->default(true);
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });

        Schema::create('web_slider', function (Blueprint $table) {
            $table->id();
            $table->string('judul')->nullable();
            $table->text('subjudul')->nullable();
            $table->string('foto_path');
            $table->string('url_aksi')->nullable();
            $table->string('label_tombol')->nullable();
            $table->boolean('aktif')->default(true);
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });

        Schema::create('web_teks_berjalan', function (Blueprint $table) {
            $table->id();
            $table->text('teks');
            $table->string('warna_teks')->default('#ffffff');
            $table->string('warna_bg')->default('#c0392b');
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->boolean('aktif')->default(true);
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });

        Schema::create('web_widget', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('judul');
            $table->string('posisi')->default('sidebar')->comment('sidebar, footer, header');
            $table->boolean('aktif')->default(true);
            $table->json('konfigurasi')->nullable();
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });

        Schema::create('web_menu', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('label');
            $table->string('url')->nullable();
            $table->string('slug')->nullable();
            $table->string('ikon')->nullable();
            $table->boolean('buka_tab_baru')->default(false);
            $table->boolean('aktif')->default(true);
            $table->integer('urutan')->default(0);
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('web_menu')->nullOnDelete();
        });

        Schema::create('web_komentar', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('artikel_id');
            $table->string('nama_komentator');
            $table->string('email_komentator')->nullable();
            $table->text('komentar');
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak', 'spam'])->default('menunggu');
            $table->string('ip_address')->nullable();
            $table->timestamps();

            $table->foreign('artikel_id')->references('id')->on('web_artikel')->onDelete('cascade');
            $table->index(['artikel_id', 'status']);
        });

        Schema::create('web_pengunjung', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->integer('jumlah_kunjungan')->default(0);
            $table->integer('jumlah_pengunjung_unik')->default(0);
            $table->timestamps();

            $table->unique('tanggal');
        });

        // ── LAPAK UMKM ───────────────────────────────────────────────
        Schema::create('lapak', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('penduduk_id')->nullable();
            $table->string('nama_usaha');
            $table->string('slug')->unique();
            $table->string('kategori')->comment('kuliner, kerajinan, pertanian, perikanan, jasa, dll');
            $table->text('deskripsi')->nullable();
            $table->string('nama_pemilik');
            $table->string('nik_pemilik', 16)->nullable();
            $table->text('alamat')->nullable();
            $table->string('telepon');
            $table->string('whatsapp')->nullable();
            $table->string('foto_usaha')->nullable();
            $table->json('foto_lainnya')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->boolean('publish')->default(false);
            $table->boolean('aktif')->default(true);
            $table->timestamps();

            $table->foreign('penduduk_id')->references('id')->on('penduduk')->nullOnDelete();
            $table->index(['kategori', 'publish']);
        });

        Schema::create('lapak_produk', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lapak_id');
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->decimal('harga', 18, 2)->nullable();
            $table->string('satuan')->nullable()->comment('per kg, per buah, dll');
            $table->integer('stok')->nullable();
            $table->string('foto_utama')->nullable();
            $table->json('foto_lainnya')->nullable();
            $table->boolean('tersedia')->default(true);
            $table->integer('urutan')->default(0);
            $table->timestamps();

            $table->foreign('lapak_id')->references('id')->on('lapak')->onDelete('cascade');
            $table->index('lapak_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lapak_produk');
        Schema::dropIfExists('lapak');
        Schema::dropIfExists('web_pengunjung');
        Schema::dropIfExists('web_komentar');
        Schema::dropIfExists('web_menu');
        Schema::dropIfExists('web_widget');
        Schema::dropIfExists('web_teks_berjalan');
        Schema::dropIfExists('web_slider');
        Schema::dropIfExists('web_potensi');
        Schema::dropIfExists('web_idm');
        Schema::dropIfExists('web_halaman');
        Schema::dropIfExists('web_galeri');
        Schema::dropIfExists('web_artikel');
        Schema::dropIfExists('tanah_persil');
        Schema::dropIfExists('peta_garis');
        Schema::dropIfExists('peta_area');
        Schema::dropIfExists('peta_lokasi');
        Schema::dropIfExists('peta_wilayah');
        Schema::dropIfExists('kehadiran_pengaduan');
        Schema::dropIfExists('kehadiran');
        Schema::dropIfExists('kehadiran_hari_libur');
        Schema::dropIfExists('kehadiran_jam_kerja');
    }
};
