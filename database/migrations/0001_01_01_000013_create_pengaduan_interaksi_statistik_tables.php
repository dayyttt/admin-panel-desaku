<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // ── PENGADUAN WARGA ──────────────────────────────────────────
        Schema::create('pengaduan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->comment('Warga yang melapor');
            $table->string('nama_pelapor');
            $table->string('nik_pelapor', 16)->nullable();
            $table->string('telepon_pelapor')->nullable();
            $table->string('kategori')->comment('infrastruktur, sampah, keamanan, layanan_desa, lainnya');
            $table->string('judul');
            $table->text('deskripsi');
            $table->json('foto')->nullable()->comment('Array path foto pengaduan');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('lokasi_text')->nullable();
            $table->enum('status', ['masuk', 'diverifikasi', 'diproses', 'selesai', 'ditolak'])->default('masuk');
            $table->text('respon_desa')->nullable();
            $table->json('foto_respon')->nullable();
            $table->unsignedBigInteger('ditangani_oleh')->nullable();
            $table->timestamp('ditangani_at')->nullable();
            $table->timestamp('diselesaikan_at')->nullable();
            $table->boolean('anonim')->default(false);
            $table->integer('urgensi')->default(1)->comment('1=rendah, 2=sedang, 3=tinggi');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            $table->index(['status', 'created_at']);
            $table->index('kategori');
        });

        // ── PESAN WARGA → DESA ───────────────────────────────────────
        Schema::create('pesan_warga', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('Warga pengirim');
            $table->string('subjek');
            $table->text('pesan');
            $table->json('lampiran')->nullable();
            $table->enum('status', ['belum_dibaca', 'dibaca', 'dibalas', 'ditutup'])->default('belum_dibaca');
            $table->text('balasan')->nullable();
            $table->unsignedBigInteger('dibalas_oleh')->nullable();
            $table->timestamp('dibalas_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['status', 'created_at']);
        });

        // ── POLLING / PENDAPAT WARGA ─────────────────────────────────
        Schema::create('pendapat', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->enum('tipe', ['pilihan_ganda', 'ya_tidak', 'rating', 'essay'])->default('pilihan_ganda');
            $table->json('opsi_jawaban')->nullable()->comment('Array opsi jika pilihan_ganda');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->boolean('aktif')->default(true);
            $table->boolean('anonim')->default(false);
            $table->boolean('satu_kali')->default(true)->comment('Warga hanya bisa jawab sekali');
            $table->timestamps();

            $table->index(['aktif', 'tanggal_mulai', 'tanggal_selesai']);
        });

        Schema::create('pendapat_jawab', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pendapat_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('nik', 16)->nullable();
            $table->text('jawaban');
            $table->string('ip_address')->nullable();
            $table->timestamps();

            $table->foreign('pendapat_id')->references('id')->on('pendapat')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            $table->index('pendapat_id');
        });

        // ── STATISTIK & ANALISIS KUSTOM ──────────────────────────────
        Schema::create('analisis', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->string('sumber_tabel')->comment('Tabel utama untuk analisis');
            $table->json('kolom_tampil')->nullable()->comment('Kolom yang ditampilkan');
            $table->json('filter_default')->nullable()->comment('Filter default yang diterapkan');
            $table->enum('tipe_grafik', ['bar', 'pie', 'line', 'table', 'number'])->default('bar');
            $table->boolean('publik')->default(false);
            $table->unsignedBigInteger('dibuat_oleh')->nullable();
            $table->timestamps();
        });

        Schema::create('analisis_kategori', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kode')->unique();
            $table->text('deskripsi')->nullable();
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });

        // ── SDGs DESA ─────────────────────────────────────────────────
        Schema::create('sdgs_indikator', function (Blueprint $table) {
            $table->id();
            $table->integer('tujuan_ke')->comment('1-17 tujuan SDGs');
            $table->string('kode_indikator');
            $table->text('nama_indikator');
            $table->string('satuan')->nullable();
            $table->enum('jenis', ['output', 'outcome', 'dampak'])->default('output');
            $table->boolean('aktif')->default(true);
            $table->timestamps();

            $table->index('tujuan_ke');
        });

        Schema::create('sdgs_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('indikator_id');
            $table->year('tahun');
            $table->string('nilai')->nullable();
            $table->string('satuan')->nullable();
            $table->text('keterangan')->nullable();
            $table->unsignedBigInteger('diinput_oleh')->nullable();
            $table->timestamps();

            $table->foreign('indikator_id')->references('id')->on('sdgs_indikator')->onDelete('cascade');
            $table->unique(['indikator_id', 'tahun']);
        });

        // ── MUSYAWARAH ───────────────────────────────────────────────
        Schema::create('musyawarah', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('jenis')->comment('musrenbangdes, lkpj, rapat_bpd, lainnya');
            $table->date('tanggal');
            $table->time('jam_mulai')->nullable();
            $table->time('jam_selesai')->nullable();
            $table->text('lokasi')->nullable();
            $table->text('agenda')->nullable();
            $table->longText('notulen')->nullable();
            $table->integer('jumlah_peserta')->nullable();
            $table->json('foto')->nullable();
            $table->string('file_notulen')->nullable();
            $table->string('file_daftar_hadir')->nullable();
            $table->json('keputusan')->nullable()->comment('Array keputusan yang diambil');
            $table->unsignedBigInteger('dibuat_oleh')->nullable();
            $table->timestamps();

            $table->index(['jenis', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('musyawarah');
        Schema::dropIfExists('sdgs_data');
        Schema::dropIfExists('sdgs_indikator');
        Schema::dropIfExists('analisis_kategori');
        Schema::dropIfExists('analisis');
        Schema::dropIfExists('pendapat_jawab');
        Schema::dropIfExists('pendapat');
        Schema::dropIfExists('pesan_warga');
        Schema::dropIfExists('pengaduan');
    }
};
