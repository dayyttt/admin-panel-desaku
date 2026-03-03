<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Perangkat desa
        Schema::create('perangkat_desa', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nip')->nullable();
            $table->string('nik', 16)->nullable();
            $table->string('jabatan');
            $table->string('foto')->nullable();
            $table->date('periode_mulai')->nullable();
            $table->date('periode_selesai')->nullable();
            $table->string('telepon')->nullable();
            $table->string('email')->nullable();
            $table->text('alamat')->nullable();
            $table->boolean('aktif')->default(true);
            $table->boolean('tampil_web')->default(true);
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });

        // Lembaga desa (BPD, PKK, Karang Taruna, LPM, dll)
        Schema::create('lembaga_desa', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('singkatan')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('logo')->nullable();
            $table->date('tanggal_berdiri')->nullable();
            $table->string('dasar_hukum')->nullable();
            $table->boolean('aktif')->default(true);
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });

        // Anggota lembaga desa
        Schema::create('lembaga_anggota', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lembaga_id');
            $table->unsignedBigInteger('penduduk_id')->nullable();
            $table->string('nama')->comment('Bisa override jika penduduk_id null');
            $table->string('jabatan');
            $table->date('periode_mulai')->nullable();
            $table->date('periode_selesai')->nullable();
            $table->string('foto')->nullable();
            $table->boolean('aktif')->default(true);
            $table->integer('urutan')->default(0);
            $table->timestamps();

            $table->foreign('lembaga_id')->references('id')->on('lembaga_desa')->onDelete('cascade');
        });

        // Layanan pelanggan (jam operasional, kontak)
        Schema::create('layanan_pelanggan', function (Blueprint $table) {
            $table->id();
            $table->string('jenis')->comment('jam_kerja, nomor_darurat, layanan');
            $table->string('label');
            $table->text('nilai');
            $table->string('ikon')->nullable();
            $table->boolean('aktif')->default(true);
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('layanan_pelanggan');
        Schema::dropIfExists('lembaga_anggota');
        Schema::dropIfExists('lembaga_desa');
        Schema::dropIfExists('perangkat_desa');
    }
};
