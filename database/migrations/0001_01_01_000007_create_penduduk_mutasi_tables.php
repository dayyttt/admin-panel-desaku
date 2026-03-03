<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Log mutasi penduduk (semua perubahan)
        Schema::create('penduduk_mutasi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('penduduk_id')->nullable();
            $table->string('nik', 16)->comment('Simpan NIK langsung jika penduduk dihapus');
            $table->enum('jenis_mutasi', ['lahir', 'mati', 'pindah_keluar', 'datang', 'ubah_data', 'hapus']);
            $table->json('data_sebelum')->nullable()->comment('Snapshot data sebelum perubahan');
            $table->json('data_sesudah')->nullable()->comment('Snapshot data sesudah perubahan');
            $table->text('keterangan')->nullable();
            $table->unsignedBigInteger('diinput_oleh')->nullable()->comment('FK ke users');
            $table->timestamp('tanggal_mutasi');
            $table->timestamps();

            $table->foreign('penduduk_id')->references('id')->on('penduduk')->nullOnDelete();
            $table->foreign('diinput_oleh')->references('id')->on('users')->nullOnDelete();
            $table->index(['nik', 'jenis_mutasi']);
            $table->index('tanggal_mutasi');
        });

        // Data kelahiran
        Schema::create('kelahiran', function (Blueprint $table) {
            $table->id();
            $table->string('nama_bayi');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->date('tanggal_lahir');
            $table->string('tempat_lahir');
            $table->time('jam_lahir')->nullable();
            $table->enum('jenis_kelahiran', ['tunggal', 'kembar_2', 'kembar_3', 'lainnya'])->default('tunggal');
            $table->integer('urutan_kelahiran')->default(1);
            $table->enum('penolong_kelahiran', ['dokter', 'bidan', 'dukun', 'lainnya'])->nullable();
            $table->string('tempat_dilahirkan')->nullable()->comment('rs, puskesmas, rumah, dll');
            $table->string('berat_bayi')->nullable()->comment('gram');
            $table->string('panjang_bayi')->nullable()->comment('cm');

            // Orang tua
            $table->string('nik_ayah', 16)->nullable();
            $table->string('nama_ayah');
            $table->string('nik_ibu', 16)->nullable();
            $table->string('nama_ibu');
            $table->string('no_kk', 16)->nullable();
            $table->unsignedBigInteger('keluarga_id')->nullable();

            // Hasil
            $table->unsignedBigInteger('penduduk_id')->nullable()->comment('Penduduk yang dibuat setelah input kelahiran');
            $table->string('no_akta_lahir')->nullable();
            $table->date('tanggal_akta')->nullable();

            $table->unsignedBigInteger('diinput_oleh')->nullable();
            $table->timestamps();

            $table->foreign('keluarga_id')->references('id')->on('keluarga')->nullOnDelete();
            $table->foreign('penduduk_id')->references('id')->on('penduduk')->nullOnDelete();
            $table->index('tanggal_lahir');
        });

        // Data kematian
        Schema::create('kematian', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('penduduk_id')->nullable();
            $table->string('nik', 16);
            $table->string('nama');
            $table->date('tanggal_kematian');
            $table->time('jam_kematian')->nullable();
            $table->string('tempat_kematian')->nullable();
            $table->text('penyebab_kematian')->nullable();
            $table->enum('jenis_kematian', ['wajar', 'tidak_wajar', 'kecelakaan', 'lainnya'])->default('wajar');
            // Pelapor
            $table->string('nama_pelapor');
            $table->string('nik_pelapor', 16)->nullable();
            $table->string('hubungan_pelapor')->nullable();
            // Akta
            $table->string('no_akta_kematian')->nullable();
            $table->date('tanggal_akta')->nullable();

            $table->unsignedBigInteger('diinput_oleh')->nullable();
            $table->timestamps();

            $table->foreign('penduduk_id')->references('id')->on('penduduk')->nullOnDelete();
            $table->index('tanggal_kematian');
            $table->index('nik');
        });

        // Data pindah keluar / pindah masuk
        Schema::create('penduduk_pindah', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('penduduk_id')->nullable();
            $table->string('nik', 16);
            $table->string('nama');
            $table->enum('jenis', ['pindah_keluar', 'datang'])->comment('pindah_keluar = pergi, datang = pindah masuk');

            // Pindah keluar
            $table->text('alamat_tujuan')->nullable();
            $table->string('desa_tujuan')->nullable();
            $table->string('kecamatan_tujuan')->nullable();
            $table->string('kabupaten_tujuan')->nullable();
            $table->string('provinsi_tujuan')->nullable();
            $table->text('alasan_pindah')->nullable();
            $table->enum('klasifikasi_pindah', ['dalam_desa', 'antar_desa', 'antar_kecamatan', 'antar_kabupaten', 'antar_provinsi'])->nullable();

            // Pindah masuk (datang)
            $table->text('alamat_asal')->nullable();
            $table->string('desa_asal')->nullable();
            $table->string('kecamatan_asal')->nullable();
            $table->string('kabupaten_asal')->nullable();
            $table->string('provinsi_asal')->nullable();
            $table->string('alasan_datang')->nullable();

            // No surat pindah
            $table->string('no_surat_pindah')->nullable();
            $table->date('tanggal_pindah');
            $table->string('no_kk_baru')->nullable();

            $table->unsignedBigInteger('diinput_oleh')->nullable();
            $table->timestamps();

            $table->foreign('penduduk_id')->references('id')->on('penduduk')->nullOnDelete();
            $table->index(['jenis', 'tanggal_pindah']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penduduk_pindah');
        Schema::dropIfExists('kematian');
        Schema::dropIfExists('kelahiran');
        Schema::dropIfExists('penduduk_mutasi');
    }
};
