<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Kartu Keluarga
        Schema::create('keluarga', function (Blueprint $table) {
            $table->id();
            $table->string('no_kk', 16)->unique();
            $table->string('nama_kepala_keluarga');
            $table->unsignedBigInteger('wilayah_rt_id')->nullable()->comment('FK ke wilayah tipe RT');
            $table->text('alamat');
            $table->string('kode_pos', 10)->nullable();
            $table->enum('status', ['aktif', 'tidak_aktif', 'pindah'])->default('aktif');
            $table->date('tanggal_buat_kk')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('wilayah_rt_id')->references('id')->on('wilayah');
            $table->index('no_kk');
            $table->index('status');
        });

        // Data penduduk lengkap sesuai Permendagri No. 2/2017
        Schema::create('penduduk', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('keluarga_id')->nullable();

            // Data Identitas
            $table->string('nik', 16)->unique();
            $table->string('nama');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('no_kk', 16)->nullable();

            // Status dalam KK
            $table->enum('status_hubungan_keluarga', [
                'kepala_keluarga', 'suami', 'istri', 'anak', 'menantu',
                'cucu', 'orang_tua', 'mertua', 'famili_lain', 'pembantu', 'lainnya'
            ])->default('anak');

            // Agama & Kewarganegaraan
            $table->enum('agama', ['islam', 'kristen', 'katolik', 'hindu', 'buddha', 'konghucu', 'lainnya']);
            $table->enum('kewarganegaraan', ['WNI', 'WNA'])->default('WNI');
            $table->string('negara_asal')->nullable()->comment('Jika WNA');

            // Status Perkawinan
            $table->enum('status_perkawinan', ['belum_kawin', 'kawin', 'cerai_hidup', 'cerai_mati'])->default('belum_kawin');
            $table->date('tanggal_perkawinan')->nullable();
            $table->string('nik_pasangan')->nullable();

            // Pendidikan
            $table->enum('pendidikan_dalam_kk', [
                'tidak_belum_sekolah', 'belum_tamat_sd', 'tamat_sd', 'sltp', 'slta',
                'd1_d2', 'd3', 's1', 's2', 's3'
            ])->nullable();
            $table->enum('pendidikan_ditamatkan', [
                'tidak_punya_ijazah', 'sd', 'smp', 'sma_smk', 'd1', 'd2', 'd3',
                's1', 's2', 's3'
            ])->nullable();

            // Pekerjaan
            $table->string('pekerjaan')->nullable();
            $table->string('pekerjaan_detail')->nullable();

            // Alamat
            $table->unsignedBigInteger('wilayah_rt_id')->nullable();
            $table->text('alamat_lengkap')->nullable();

            // Fisik
            $table->string('golongan_darah', 5)->nullable();
            $table->integer('tinggi_badan')->nullable()->comment('cm');
            $table->integer('berat_badan')->nullable()->comment('kg');
            $table->boolean('cacat')->default(false);
            $table->string('jenis_cacat')->nullable();

            // Data Tambahan
            $table->string('ayah_nama')->nullable();
            $table->string('ayah_nik', 16)->nullable();
            $table->string('ibu_nama')->nullable();
            $table->string('ibu_nik', 16)->nullable();
            $table->string('no_akta_lahir')->nullable();
            $table->string('no_akta_perkawinan')->nullable();
            $table->string('no_akta_cerai')->nullable();
            $table->string('no_paspor')->nullable();
            $table->date('tanggal_akhir_paspor')->nullable();
            $table->string('no_kitas_kitap')->nullable();

            // Asuransi & Bantuan
            $table->string('no_bpjs_kesehatan')->nullable();
            $table->string('no_bpjs_ketenagakerjaan')->nullable();
            $table->boolean('penerima_bantuan')->default(false);

            // Status
            $table->enum('status', ['aktif', 'mati', 'pindah', 'hilang', 'sementara'])->default('aktif');
            $table->date('tanggal_masuk')->nullable()->comment('Tanggal pindah masuk jika pendatang');
            $table->string('asal_daerah')->nullable()->comment('Jika pendatang');

            // Foto & Dokumen
            $table->string('foto')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('keluarga_id')->references('id')->on('keluarga');
            $table->foreign('wilayah_rt_id')->references('id')->on('wilayah');
            $table->index('nik');
            $table->index('nama');
            $table->index(['status', 'jenis_kelamin']);
            $table->index('tanggal_lahir');
            $table->fullText(['nama', 'nik']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penduduk');
        Schema::dropIfExists('keluarga');
    }
};
