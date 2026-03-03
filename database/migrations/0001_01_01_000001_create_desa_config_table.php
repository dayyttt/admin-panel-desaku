<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('desa_config', function (Blueprint $table) {
            $table->id();
            // Identitas Desa
            $table->string('nama_desa')->default('Desa Lesane');
            $table->string('kode_desa', 20)->nullable()->comment('Kode 10 digit kemendagri');
            $table->string('kode_pos', 10)->nullable();
            $table->string('nama_kecamatan')->default('Teluti');
            $table->string('nama_kabupaten')->default('Maluku Tengah');
            $table->string('nama_provinsi')->default('Maluku');
            $table->text('alamat_kantor')->nullable();
            $table->string('telepon')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            // Koordinat GPS
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            // Logo & Tampilan
            $table->string('logo_path')->nullable();
            $table->string('foto_kantor_path')->nullable();
            $table->string('tema_warna', 10)->default('#1F3864');
            $table->string('bg_web_path')->nullable();
            // Visi Misi
            $table->text('visi')->nullable();
            $table->text('misi')->nullable();
            $table->text('sejarah')->nullable();
            // Pimpinan
            $table->string('nama_kepala_desa')->nullable();
            $table->string('nip_kepala_desa')->nullable();
            $table->string('foto_kepala_desa')->nullable();
            $table->string('ttd_kepala_desa')->nullable()->comment('Path file TTD digital');
            $table->string('stempel_desa')->nullable()->comment('Path file stempel desa');
            // Konfigurasi Surat
            $table->string('format_nomor_surat')->default('{nomor}/{kode_desa}/{bulan_romawi}/{tahun}');
            $table->string('kode_surat_desa')->default('Des-LSN');
            // Konfigurasi Tahun Anggaran
            $table->year('tahun_apbdes_aktif')->nullable();
            // Integrasi
            $table->string('wa_api_key')->nullable();
            $table->string('wa_api_url')->nullable();
            $table->string('wa_nomor_desa')->nullable();
            $table->string('fcm_server_key')->nullable();
            $table->string('smtp_host')->nullable();
            $table->string('smtp_port')->nullable();
            $table->string('smtp_user')->nullable();
            $table->string('smtp_pass')->nullable();
            $table->string('smtp_from_name')->nullable();
            // Sosial Media
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('youtube')->nullable();
            $table->string('twitter')->nullable();
            // IDM
            $table->decimal('skor_idm_terakhir', 5, 4)->nullable();
            $table->string('status_idm')->nullable();
            $table->year('tahun_idm_terakhir')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('desa_config');
    }
};
