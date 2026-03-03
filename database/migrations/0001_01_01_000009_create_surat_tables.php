<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Kategori surat
        Schema::create('surat_kategori', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kode')->unique();
            $table->text('deskripsi')->nullable();
            $table->integer('urutan')->default(0);
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        // Jenis / Master surat
        Schema::create('surat_jenis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kategori_id')->nullable();
            $table->string('nama');
            $table->string('kode')->unique();
            $table->string('singkatan')->nullable()->comment('Misal: SKTM, SKD, N1');
            $table->text('deskripsi')->nullable();
            $table->string('template_path')->nullable()->comment('Path file .docx template');
            $table->json('variabel')->nullable()->comment('Daftar variabel yang digunakan di template');
            $table->json('field_tambahan')->nullable()->comment('Field yang perlu diisi manual oleh operator');
            // Penomoran surat
            $table->string('format_nomor')->nullable()->comment('Override format default desa');
            $table->integer('nomor_terakhir')->default(0);
            $table->year('tahun_nomor')->nullable();
            // Pengaturan
            $table->boolean('perlu_ttd_kades')->default(true);
            $table->boolean('aktif_permohonan_online')->default(true);
            $table->boolean('aktif')->default(true);
            $table->integer('urutan')->default(0);
            $table->timestamps();

            $table->foreign('kategori_id')->references('id')->on('surat_kategori')->nullOnDelete();
        });

        // Persyaratan per jenis surat
        Schema::create('surat_persyaratan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('surat_jenis_id');
            $table->string('nama_syarat');
            $table->text('keterangan')->nullable();
            $table->boolean('wajib')->default(true);
            $table->integer('urutan')->default(0);
            $table->timestamps();

            $table->foreign('surat_jenis_id')->references('id')->on('surat_jenis')->onDelete('cascade');
        });

        // Template TTD & stempel
        Schema::create('dokumen_ttd', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('jabatan');
            $table->string('ttd_path')->nullable();
            $table->string('stempel_path')->nullable();
            $table->boolean('aktif')->default(true);
            $table->boolean('default')->default(false);
            $table->timestamps();
        });

        // Arsip surat yang diterbitkan
        Schema::create('surat_arsip', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('surat_jenis_id');
            $table->unsignedBigInteger('penduduk_id')->nullable()->comment('Pemohon/subjek surat');
            $table->string('nik_pemohon', 16)->nullable();
            $table->string('nama_pemohon');
            $table->string('nomor_surat')->unique();
            $table->date('tanggal_surat');
            $table->text('keperluan')->nullable();
            $table->json('data_surat')->nullable()->comment('Semua data yang digunakan untuk generate surat');
            $table->string('file_pdf_path')->nullable();
            $table->string('qr_code')->nullable()->unique()->comment('Kode unik untuk verifikasi');
            $table->unsignedBigInteger('ttd_id')->nullable();
            $table->unsignedBigInteger('dibuat_oleh')->nullable();
            $table->unsignedBigInteger('permohonan_id')->nullable()->comment('FK jika dari permohonan online');
            $table->timestamps();

            $table->foreign('surat_jenis_id')->references('id')->on('surat_jenis');
            $table->foreign('penduduk_id')->references('id')->on('penduduk')->nullOnDelete();
            $table->foreign('ttd_id')->references('id')->on('dokumen_ttd')->nullOnDelete();
            $table->index(['tanggal_surat', 'surat_jenis_id']);
            $table->index('nik_pemohon');
        });

        // Permohonan surat online dari warga
        Schema::create('surat_permohonan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('surat_jenis_id');
            $table->unsignedBigInteger('user_id')->comment('Warga yang mengajukan');
            $table->unsignedBigInteger('penduduk_id')->nullable();
            $table->string('nik', 16);
            $table->string('nama');
            $table->text('keperluan');
            $table->json('data_tambahan')->nullable()->comment('Field tambahan yang diisi warga');
            $table->json('dokumen_pendukung')->nullable()->comment('Lampiran dokumen dari warga');
            $table->enum('status', ['menunggu', 'diproses', 'selesai', 'ditolak'])->default('menunggu');
            $table->text('catatan_operator')->nullable();
            $table->text('alasan_tolak')->nullable();
            $table->unsignedBigInteger('diproses_oleh')->nullable();
            $table->timestamp('diproses_at')->nullable();
            $table->unsignedBigInteger('surat_arsip_id')->nullable()->comment('Surat yang sudah diterbitkan');
            $table->timestamps();

            $table->foreign('surat_jenis_id')->references('id')->on('surat_jenis');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('penduduk_id')->references('id')->on('penduduk')->nullOnDelete();
            $table->index(['status', 'created_at']);
            $table->index('user_id');
        });

        // Surat masuk dari luar
        Schema::create('surat_masuk', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat');
            $table->date('tanggal_surat');
            $table->date('tanggal_diterima');
            $table->string('asal_pengirim');
            $table->string('perihal');
            $table->text('ringkasan')->nullable();
            $table->string('file_path')->nullable();
            $table->string('klasifikasi')->nullable();
            $table->enum('sifat', ['biasa', 'segera', 'sangat_segera', 'rahasia'])->default('biasa');
            $table->string('disposisi')->nullable();
            $table->unsignedBigInteger('diterima_oleh')->nullable();
            $table->timestamps();

            $table->foreign('diterima_oleh')->references('id')->on('users')->nullOnDelete();
        });

        // Buku agenda surat keluar
        Schema::create('buku_agenda', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('surat_arsip_id');
            $table->integer('nomor_agenda');
            $table->year('tahun');
            $table->string('tujuan_surat');
            $table->string('perihal');
            $table->date('tanggal');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('surat_arsip_id')->references('id')->on('surat_arsip')->onDelete('cascade');
        });

        // Buku ekspedisi (pengiriman surat)
        Schema::create('surat_ekspedisi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('surat_arsip_id');
            $table->string('nama_penerima');
            $table->string('alamat_penerima')->nullable();
            $table->date('tanggal_kirim');
            $table->enum('metode_kirim', ['langsung', 'pos', 'kurir', 'lainnya'])->default('langsung');
            $table->string('nomor_resi')->nullable();
            $table->boolean('sudah_diterima')->default(false);
            $table->date('tanggal_diterima')->nullable();
            $table->string('tanda_tangan_penerima')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('surat_arsip_id')->references('id')->on('surat_arsip');
        });

        // Klasifikasi surat
        Schema::create('surat_klasifikasi', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('nama');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('surat_klasifikasi');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_klasifikasi');
        Schema::dropIfExists('surat_ekspedisi');
        Schema::dropIfExists('buku_agenda');
        Schema::dropIfExists('surat_masuk');
        Schema::dropIfExists('surat_permohonan');
        Schema::dropIfExists('surat_arsip');
        Schema::dropIfExists('dokumen_ttd');
        Schema::dropIfExists('surat_persyaratan');
        Schema::dropIfExists('surat_jenis');
        Schema::dropIfExists('surat_kategori');
    }
};
