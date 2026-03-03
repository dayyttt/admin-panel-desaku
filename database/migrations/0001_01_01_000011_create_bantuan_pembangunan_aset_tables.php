<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // ── BANTUAN SOSIAL ──────────────────────────────────────────
        Schema::create('bantuan_program', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('singkatan')->nullable()->comment('PKH, BLT, BPNT, dll');
            $table->text('deskripsi')->nullable();
            $table->string('sumber_dana')->nullable()->comment('APBN, APBD, APBDes');
            $table->string('penyelenggara')->nullable()->comment('Kemensos, Pemkab, dll');
            $table->enum('jenis_bantuan', ['uang_tunai', 'sembako', 'layanan', 'barang', 'lainnya'])->default('uang_tunai');
            $table->decimal('nominal_per_penerima', 18, 2)->nullable();
            $table->string('satuan_nominal')->nullable()->comment('per bulan, per tahap, dll');
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        Schema::create('bantuan_penerima', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('program_id');
            $table->unsignedBigInteger('penduduk_id')->nullable();
            $table->string('nik', 16);
            $table->string('nama');
            $table->year('tahun');
            $table->integer('periode')->nullable()->comment('Bulan atau tahap');
            $table->decimal('nominal', 18, 2)->nullable();
            $table->enum('status', ['aktif', 'nonaktif', 'graduasi'])->default('aktif');
            $table->date('tanggal_diterima')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('program_id')->references('id')->on('bantuan_program');
            $table->foreign('penduduk_id')->references('id')->on('penduduk')->nullOnDelete();
            $table->index(['program_id', 'tahun', 'status']);
            $table->index('nik');
        });

        // ── PEMBANGUNAN ──────────────────────────────────────────────
        Schema::create('pembangunan_rkp', function (Blueprint $table) {
            $table->id();
            $table->year('tahun');
            $table->string('nama_kegiatan');
            $table->string('bidang')->nullable();
            $table->text('lokasi')->nullable();
            $table->decimal('volume', 10, 2)->nullable();
            $table->string('satuan_volume')->nullable();
            $table->decimal('anggaran', 18, 2)->default(0);
            $table->string('sumber_dana')->nullable();
            $table->enum('prioritas', ['tinggi', 'sedang', 'rendah'])->default('sedang');
            $table->enum('status', ['rencana', 'disetujui', 'berjalan', 'selesai', 'batal'])->default('rencana');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->index('tahun');
        });

        Schema::create('pembangunan_kegiatan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rkp_id')->nullable();
            $table->unsignedBigInteger('apbdes_bidang_id')->nullable();
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->text('lokasi');
            $table->decimal('panjang', 10, 2)->nullable()->comment('meter, jika infrastruktur');
            $table->decimal('lebar', 10, 2)->nullable();
            $table->string('satuan')->nullable();
            $table->decimal('anggaran', 18, 2)->default(0);
            $table->decimal('realisasi', 18, 2)->default(0);
            $table->integer('progres_fisik')->default(0)->comment('0-100 persen');
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai_rencana')->nullable();
            $table->date('tanggal_selesai_aktual')->nullable();
            $table->string('kontraktor')->nullable();
            $table->enum('status', ['perencanaan', 'lelang', 'berjalan', 'selesai', 'berhenti'])->default('perencanaan');
            $table->json('foto_progres')->nullable()->comment('Array path foto progres');
            $table->timestamps();

            $table->foreign('rkp_id')->references('id')->on('pembangunan_rkp')->nullOnDelete();
            $table->foreign('apbdes_bidang_id')->references('id')->on('apbdes_bidang')->nullOnDelete();
        });

        Schema::create('pembangunan_inventaris', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kegiatan_id')->nullable();
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->string('lokasi')->nullable();
            $table->date('tanggal_serah_terima')->nullable();
            $table->string('penerima')->nullable()->comment('Nama/kelompok penerima');
            $table->string('kondisi')->default('baik');
            $table->decimal('nilai', 18, 2)->nullable();
            $table->string('foto')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('kegiatan_id')->references('id')->on('pembangunan_kegiatan')->nullOnDelete();
        });

        Schema::create('kader_masyarakat', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('penduduk_id')->nullable();
            $table->string('nama');
            $table->string('nik', 16)->nullable();
            $table->string('jenis_kader')->comment('posyandu, pkk, paud, karang_taruna, dll');
            $table->string('wilayah')->nullable();
            $table->date('tanggal_bergabung')->nullable();
            $table->boolean('aktif')->default(true);
            $table->string('sertifikat')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('penduduk_id')->references('id')->on('penduduk')->nullOnDelete();
        });

        // ── ASET DESA ────────────────────────────────────────────────
        Schema::create('aset_kategori', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kode')->unique();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        Schema::create('aset', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kategori_id');
            $table->string('nama');
            $table->string('kode_inventaris')->nullable()->unique();
            $table->integer('tahun_perolehan')->nullable();
            $table->string('cara_perolehan')->nullable()->comment('beli, hibah, dana_desa, dll');
            $table->decimal('nilai_perolehan', 18, 2)->nullable();
            $table->string('kondisi')->default('baik')->comment('baik, rusak_ringan, rusak_berat, hilang');
            $table->text('lokasi')->nullable();
            $table->decimal('luas', 10, 2)->nullable()->comment('m2 jika tanah/bangunan');
            $table->string('satuan')->nullable();
            $table->decimal('volume', 10, 2)->nullable();
            $table->string('foto')->nullable();
            $table->text('keterangan')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();

            $table->foreign('kategori_id')->references('id')->on('aset_kategori');
        });

        Schema::create('tanah_kas_desa', function (Blueprint $table) {
            $table->id();
            $table->string('nama_bidang');
            $table->string('nomor_persil')->nullable();
            $table->string('kelas_tanah')->nullable();
            $table->decimal('luas', 12, 2)->nullable()->comment('m2');
            $table->text('lokasi')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->enum('status_tanah', ['milik_desa', 'sewa', 'pinjam_pakai', 'sengketa'])->default('milik_desa');
            $table->string('nomor_sertifikat')->nullable();
            $table->date('tanggal_sertifikat')->nullable();
            $table->string('penggunaan_tanah')->nullable()->comment('sawah, kebun, bangunan, dll');
            $table->decimal('nilai_tanah', 18, 2)->nullable();
            $table->text('keterangan')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
        });

        // ── SEKRETARIAT ──────────────────────────────────────────────
        Schema::create('produk_hukum', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis', ['perdes', 'perkades', 'sk', 'keputusan_bpd', 'lainnya']);
            $table->string('nomor');
            $table->year('tahun');
            $table->string('judul');
            $table->text('tentang')->nullable();
            $table->date('tanggal_ditetapkan')->nullable();
            $table->date('tanggal_berlaku')->nullable();
            $table->string('file_path')->nullable();
            $table->boolean('tampil_publik')->default(true);
            $table->enum('status', ['draft', 'aktif', 'dicabut'])->default('aktif');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->index(['jenis', 'tahun']);
        });

        Schema::create('informasi_publik', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('kategori')->comment('lppd, apbdes, rpjmdes, rkpdes, lainnya');
            $table->year('tahun')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('file_path')->nullable();
            $table->string('url_eksternal')->nullable();
            $table->boolean('aktif')->default(true);
            $table->integer('urutan')->default(0);
            $table->unsignedBigInteger('diupload_oleh')->nullable();
            $table->timestamps();
        });

        Schema::create('arsip_desa', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('kode_arsip')->nullable();
            $table->string('kategori')->nullable();
            $table->integer('tahun')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('file_path');
            $table->string('lokasi_fisik')->nullable()->comment('Rak/lemari arsip fisik');
            $table->integer('jumlah_halaman')->nullable();
            $table->enum('kondisi', ['baik', 'rusak_ringan', 'rusak_berat'])->default('baik');
            $table->unsignedBigInteger('diupload_oleh')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('arsip_desa');
        Schema::dropIfExists('informasi_publik');
        Schema::dropIfExists('produk_hukum');
        Schema::dropIfExists('tanah_kas_desa');
        Schema::dropIfExists('aset');
        Schema::dropIfExists('aset_kategori');
        Schema::dropIfExists('kader_masyarakat');
        Schema::dropIfExists('pembangunan_inventaris');
        Schema::dropIfExists('pembangunan_kegiatan');
        Schema::dropIfExists('pembangunan_rkp');
        Schema::dropIfExists('bantuan_penerima');
        Schema::dropIfExists('bantuan_program');
    }
};
