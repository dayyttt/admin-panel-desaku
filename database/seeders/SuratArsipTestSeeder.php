<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SuratArsip;
use App\Models\SuratJenis;
use App\Models\Penduduk;
use App\Models\User;

class SuratArsipTestSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil jenis surat pertama (Surat Pengantar KTP)
        $suratJenis = SuratJenis::where('kode', 'SKT-KTP-001')->first();
        
        if (!$suratJenis) {
            $this->command->error('Jenis surat tidak ditemukan. Jalankan SuratJenisSeeder dulu.');
            return;
        }

        // Ambil penduduk pertama
        $penduduk = Penduduk::first();
        
        if (!$penduduk) {
            $this->command->error('Data penduduk tidak ditemukan. Jalankan PendudukSeeder dulu.');
            return;
        }

        // Ambil user admin
        $admin = User::where('email', 'superadmin@desa.id')->first();

        // Generate nomor surat
        $nomorSurat = $suratJenis->generateNomorSurat();

        // Buat surat arsip test
        $surat = SuratArsip::create([
            'surat_jenis_id' => $suratJenis->id,
            'penduduk_id' => $penduduk->id,
            'nik_pemohon' => $penduduk->nik,
            'nama_pemohon' => $penduduk->nama,
            'nomor_surat' => $nomorSurat,
            'tanggal_surat' => now(),
            'keperluan' => 'Pembuatan KTP baru',
            'data_surat' => null,
            'dibuat_oleh' => $admin?->id,
        ]);

        $this->command->info('✅ Test surat arsip berhasil dibuat:');
        $this->command->info('   Nomor: ' . $surat->nomor_surat);
        $this->command->info('   Jenis: ' . $suratJenis->nama);
        $this->command->info('   Pemohon: ' . $penduduk->nama);
    }
}
