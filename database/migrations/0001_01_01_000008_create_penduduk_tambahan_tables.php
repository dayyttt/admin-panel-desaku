<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Pengelompokan rumah tangga (beda dengan KK)
        Schema::create('rumah_tangga', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique()->nullable();
            $table->string('nama_kepala_rt');
            $table->string('nik_kepala', 16)->nullable();
            $table->unsignedBigInteger('wilayah_rt_id')->nullable();
            $table->integer('jumlah_anggota')->default(0);
            $table->enum('kategori_ekonomi', ['sangat_miskin', 'miskin', 'hampir_miskin', 'tidak_miskin'])->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('wilayah_rt_id')->references('id')->on('wilayah');
        });

        // Anggota rumah tangga (many-to-many penduduk)
        Schema::create('rumah_tangga_anggota', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rumah_tangga_id');
            $table->unsignedBigInteger('penduduk_id');
            $table->string('hubungan')->nullable();
            $table->timestamps();

            $table->foreign('rumah_tangga_id')->references('id')->on('rumah_tangga')->onDelete('cascade');
            $table->foreign('penduduk_id')->references('id')->on('penduduk')->onDelete('cascade');
            $table->unique(['rumah_tangga_id', 'penduduk_id']);
        });

        // Kelompok penduduk kustom
        Schema::create('kelompok', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kode')->unique()->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('ketua_nama')->nullable();
            $table->string('ketua_nik', 16)->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        // Anggota kelompok
        Schema::create('kelompok_anggota', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kelompok_id');
            $table->unsignedBigInteger('penduduk_id');
            $table->string('jabatan')->nullable();
            $table->date('tanggal_bergabung')->nullable();
            $table->timestamps();

            $table->foreign('kelompok_id')->references('id')->on('kelompok')->onDelete('cascade');
            $table->foreign('penduduk_id')->references('id')->on('penduduk')->onDelete('cascade');
            $table->unique(['kelompok_id', 'penduduk_id']);
        });

        // Definisi field suplemen kustom
        Schema::create('data_suplemen', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kode')->unique();
            $table->enum('tipe_input', ['text', 'textarea', 'number', 'date', 'select', 'radio', 'checkbox', 'file']);
            $table->json('opsi')->nullable()->comment('Opsi untuk select/radio/checkbox');
            $table->boolean('wajib')->default(false);
            $table->text('keterangan')->nullable();
            $table->integer('urutan')->default(0);
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        // Nilai field suplemen per penduduk
        Schema::create('suplemen_terisi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('penduduk_id');
            $table->unsignedBigInteger('data_suplemen_id');
            $table->text('nilai')->nullable();
            $table->timestamps();

            $table->foreign('penduduk_id')->references('id')->on('penduduk')->onDelete('cascade');
            $table->foreign('data_suplemen_id')->references('id')->on('data_suplemen')->onDelete('cascade');
            $table->unique(['penduduk_id', 'data_suplemen_id']);
        });

        // Penduduk sementara
        Schema::create('penduduk_sementara', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nik', 16)->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('agama')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->text('alamat_asal')->nullable();
            $table->string('kabupaten_asal')->nullable();
            $table->string('provinsi_asal')->nullable();
            $table->text('alamat_di_desa')->nullable();
            $table->unsignedBigInteger('wilayah_rt_id')->nullable();
            $table->date('tanggal_masuk');
            $table->date('tanggal_keluar')->nullable();
            $table->string('tujuan_tinggal')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();

            $table->foreign('wilayah_rt_id')->references('id')->on('wilayah');
        });

        // Dokumen scan per penduduk
        Schema::create('dokumen_penduduk', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('penduduk_id');
            $table->enum('jenis_dokumen', ['ktp', 'kk', 'akta_lahir', 'akta_nikah', 'ijazah', 'bpjs', 'paspor', 'lainnya']);
            $table->string('nama_dokumen');
            $table->string('file_path');
            $table->string('nomor_dokumen')->nullable();
            $table->date('tanggal_dokumen')->nullable();
            $table->date('masa_berlaku')->nullable();
            $table->text('keterangan')->nullable();
            $table->unsignedBigInteger('diupload_oleh')->nullable();
            $table->timestamps();

            $table->foreign('penduduk_id')->references('id')->on('penduduk')->onDelete('cascade');
            $table->index('penduduk_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumen_penduduk');
        Schema::dropIfExists('penduduk_sementara');
        Schema::dropIfExists('suplemen_terisi');
        Schema::dropIfExists('data_suplemen');
        Schema::dropIfExists('kelompok_anggota');
        Schema::dropIfExists('kelompok');
        Schema::dropIfExists('rumah_tangga_anggota');
        Schema::dropIfExists('rumah_tangga');
    }
};
