<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── 1. Konfigurasi Desa Lesane ─────────────────────
        DB::table('desa_config')->insert([
            'nama_desa'         => 'Desa Lesane',
            'kode_desa'         => '8102042006',
            'kode_pos'          => '97514',
            'nama_kecamatan'    => 'Teluti',
            'nama_kabupaten'    => 'Maluku Tengah',
            'nama_provinsi'     => 'Maluku',
            'alamat_kantor'     => 'Jl. Raya Lesane, Kecamatan Teluti, Kabupaten Maluku Tengah',
            'telepon'           => '-',
            'email'             => 'desa.lesane@gmail.com',
            'website'           => 'https://desalesane.id',
            'latitude'          => -3.3565,
            'longitude'         => 128.1893,
            'tema_warna'        => '#1B5E20',
            'visi'              => 'Mewujudkan Desa Lesane yang mandiri, sejahtera, dan berbudaya melalui tata kelola pemerintahan yang baik dan pemberdayaan masyarakat.',
            'misi'              => "1. Meningkatkan kualitas pelayanan publik\n2. Meningkatkan kesejahteraan masyarakat melalui pengembangan potensi desa\n3. Melestarikan adat istiadat dan budaya lokal\n4. Meningkatkan infrastruktur desa\n5. Mendorong partisipasi masyarakat dalam pembangunan",
            'sejarah'           => 'Desa Lesane adalah salah satu desa di Kecamatan Teluti, Kabupaten Maluku Tengah, Provinsi Maluku. Terletak di pesisir selatan Pulau Seram, desa ini memiliki sejarah panjang sebagai pemukiman masyarakat adat Maluku Tengah. Nama "Lesane" berasal dari bahasa lokal yang memiliki makna mendalam bagi masyarakat adat setempat.',
            'nama_kepala_desa'  => 'Bapak Muhammad Latuconsina',
            'format_nomor_surat'=> '{nomor}/{kode_desa}/{bulan_romawi}/{tahun}',
            'kode_surat_desa'   => 'Des-LSN',
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        // ── 2. Wilayah (Dusun → RT) ──────────────────────
        // Dusun 1
        $dusun1 = DB::table('wilayah')->insertGetId([
            'nama' => 'Dusun Satu', 'tipe' => 'dusun', 'kode' => '001',
            'parent_id' => null, 'created_at' => now(), 'updated_at' => now(),
        ]);
        $rt1 = DB::table('wilayah')->insertGetId([
            'nama' => 'RT 001', 'tipe' => 'rt', 'kode' => '001',
            'parent_id' => $dusun1, 'created_at' => now(), 'updated_at' => now(),
        ]);
        DB::table('wilayah')->insert([
            'nama' => 'RT 002', 'tipe' => 'rt', 'kode' => '002',
            'parent_id' => $dusun1, 'created_at' => now(), 'updated_at' => now(),
        ]);

        // Dusun 2
        $dusun2 = DB::table('wilayah')->insertGetId([
            'nama' => 'Dusun Dua', 'tipe' => 'dusun', 'kode' => '002',
            'parent_id' => null, 'created_at' => now(), 'updated_at' => now(),
        ]);
        DB::table('wilayah')->insert([
            'nama' => 'RT 003', 'tipe' => 'rt', 'kode' => '003',
            'parent_id' => $dusun2, 'created_at' => now(), 'updated_at' => now(),
        ]);
        DB::table('wilayah')->insert([
            'nama' => 'RT 004', 'tipe' => 'rt', 'kode' => '004',
            'parent_id' => $dusun2, 'created_at' => now(), 'updated_at' => now(),
        ]);

        // Dusun 3
        $dusun3 = DB::table('wilayah')->insertGetId([
            'nama' => 'Dusun Tiga', 'tipe' => 'dusun', 'kode' => '003',
            'parent_id' => null, 'created_at' => now(), 'updated_at' => now(),
        ]);
        DB::table('wilayah')->insert([
            'nama' => 'RT 005', 'tipe' => 'rt', 'kode' => '005',
            'parent_id' => $dusun3, 'created_at' => now(), 'updated_at' => now(),
        ]);

        // ── 3. Users ──────────────────────────────────────
        User::create([
            'name'     => 'Super Admin',
            'username' => 'superadmin',
            'email'    => 'admin@desalesane.id',
            'password' => Hash::make('admin123'),
            'tipe'     => 'superadmin',
            'aktif'    => true,
        ]);

        User::create([
            'name'     => 'Operator Desa',
            'username' => 'operator',
            'email'    => 'operator@desalesane.id',
            'password' => Hash::make('operator123'),
            'tipe'     => 'operator',
            'aktif'    => true,
        ]);

        User::create([
            'name'     => 'Muhammad Latuconsina',
            'username' => 'kades',
            'email'    => 'kades@desalesane.id',
            'password' => Hash::make('kades123'),
            'tipe'     => 'kepala_desa',
            'aktif'    => true,
        ]);
        
        // Additional users
        $this->call(UserSeeder::class);

        // ── 4. Perangkat Desa ─────────────────────────────
        DB::table('perangkat_desa')->insert([
            [
                'nama' => 'Muhammad Latuconsina', 'nik' => '8102040101800001',
                'jabatan' => 'Kepala Desa / Raja Negeri', 'aktif' => true,
                'telepon' => '081234567890', 'periode_mulai' => '2020-01-01',
                'tampil_web' => true, 'urutan' => 1,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'nama' => 'Ahmad Sopaheluwakan', 'nik' => '8102040201850002',
                'jabatan' => 'Sekretaris Desa', 'aktif' => true,
                'telepon' => '081234567891', 'periode_mulai' => '2020-06-01',
                'tampil_web' => true, 'urutan' => 2,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'nama' => 'Fatima Tuasamu', 'nik' => '8102040301900003',
                'jabatan' => 'Kaur Keuangan', 'aktif' => true,
                'telepon' => '081234567892', 'periode_mulai' => '2020-06-01',
                'tampil_web' => true, 'urutan' => 3,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'nama' => 'Ibrahim Laturua', 'nik' => '8102040401880004',
                'jabatan' => 'Kaur Perencanaan', 'aktif' => true,
                'telepon' => '081234567893', 'periode_mulai' => '2021-01-01',
                'tampil_web' => true, 'urutan' => 4,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'nama' => 'Siti Hatala', 'nik' => '8102040501920005',
                'jabatan' => 'Kaur Umum & Tata Usaha', 'aktif' => true,
                'telepon' => '081234567894', 'periode_mulai' => '2021-01-01',
                'tampil_web' => true, 'urutan' => 5,
                'created_at' => now(), 'updated_at' => now(),
            ],
        ]);

        // ── 5. Surat Kategori & Jenis (5 sample) ─────────
        $katAdm = DB::table('surat_kategori')->insertGetId([
            'nama' => 'Administrasi Kependudukan', 'kode' => 'ADM',
            'deskripsi' => 'Surat-surat terkait administrasi dan kependudukan',
            'urutan' => 1, 'aktif' => true, 'created_at' => now(), 'updated_at' => now(),
        ]);

        $katUsaha = DB::table('surat_kategori')->insertGetId([
            'nama' => 'Usaha & Perizinan', 'kode' => 'USH',
            'deskripsi' => 'Surat keterangan usaha dan perizinan',
            'urutan' => 2, 'aktif' => true, 'created_at' => now(), 'updated_at' => now(),
        ]);

        DB::table('surat_jenis')->insert([
            [
                'kategori_id' => $katAdm, 'nama' => 'Surat Keterangan Domisili',
                'kode' => '001/SKTD', 'singkatan' => 'SKTD',
                'deskripsi' => 'Surat keterangan tempat tinggal/domisili',
                'perlu_ttd_kades' => true, 'aktif_permohonan_online' => true,
                'aktif' => true, 'urutan' => 1,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'kategori_id' => $katAdm, 'nama' => 'Surat Keterangan Tidak Mampu',
                'kode' => '002/SKTM', 'singkatan' => 'SKTM',
                'deskripsi' => 'Surat keterangan tidak mampu untuk bantuan pendidikan/kesehatan',
                'perlu_ttd_kades' => true, 'aktif_permohonan_online' => true,
                'aktif' => true, 'urutan' => 2,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'kategori_id' => $katAdm, 'nama' => 'Surat Keterangan Kelahiran',
                'kode' => '003/SKK', 'singkatan' => 'SKK',
                'deskripsi' => 'Surat keterangan kelahiran bayi',
                'perlu_ttd_kades' => true, 'aktif_permohonan_online' => true,
                'aktif' => true, 'urutan' => 3,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'kategori_id' => $katUsaha, 'nama' => 'Surat Keterangan Usaha',
                'kode' => '008/SKU', 'singkatan' => 'SKU',
                'deskripsi' => 'Surat keterangan memiliki usaha',
                'perlu_ttd_kades' => true, 'aktif_permohonan_online' => true,
                'aktif' => true, 'urutan' => 1,
                'created_at' => now(), 'updated_at' => now(),
            ],
        ]);

        // ── 6. Penduduk & Keluarga ───────────────────────
        $this->call(PendudukSeeder::class);
        $this->call(KeluargaSeeder::class);
        
        // ── 7. Perangkat Desa (Extended) ─────────────────
        $this->call(PerangkatDesaSeeder::class);
        
        // ── 8. Keuangan (APBDes & Transaksi) ─────────────
        $this->call(ApbdesSeeder::class);
        $this->call(KeuanganTransaksiSeeder::class);
        $this->call(BukuKasSeeder::class);
        $this->call(BukuBankSeeder::class);
        
        // ── 9. Mutasi Penduduk ───────────────────────────
        $this->call(KelahiranSeeder::class);
        $this->call(KematianSeeder::class);
        $this->call(PendudukPindahSeeder::class);
        $this->call(PendudukMutasiSeeder::class);
        
        // ── 10. Surat (Extended) ─────────────────────────
        $this->call(SuratJenisSeeder::class);
        $this->call(DokumenTtdSeeder::class);
        $this->call(SuratArsipSeeder::class);
        $this->call(SuratMasukSeeder::class);
        
        // ── 11. Aset & Sekretariat ───────────────────────
        $this->call(AsetSeeder::class);
        $this->call(TanahKasDesaSeeder::class);
        $this->call(SekretariatSeeder::class);
        
        // ── 12. Pembangunan & Bantuan ────────────────────
        $this->call(PembangunanSeeder::class);
        $this->call(BantuanSosialSeeder::class);
        
        // ── 13. Web Publik ───────────────────────────────
        $this->call(DesaInfoSeeder::class);
        $this->call(WebPublikSeeder::class);
        $this->call(PesanMasukSeeder::class);

        $this->command->info('✅ Seeder Desa Lesane berhasil! Login: superadmin / admin123');
    }
}
