<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SuratKategori;
use App\Models\SuratJenis;

class SuratJenisSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🌱 Starting Surat Jenis Seeder...');
        $this->command->newLine();

        // Truncate
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        SuratJenis::truncate();
        SuratKategori::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Create Kategori
        $this->createKategori();
        
        // Create 20 Jenis Surat
        $this->createJenisSurat();

        $this->command->newLine();
        $this->command->info('🎉 Surat Jenis Seeder Completed!');
        $this->command->info('📊 Total Kategori: 4');
        $this->command->info('📊 Total Jenis Surat: 20');
    }

    private function createKategori()
    {
        $this->command->info('📁 Creating Kategori Surat...');
        
        $kategoris = [
            ['nama' => 'Administrasi Kependudukan', 'kode' => 'ADM-KDP', 'deskripsi' => 'Surat terkait kependudukan (KTP, KK, Kelahiran, Kematian, dll)', 'urutan' => 1],
            ['nama' => 'Administrasi Umum', 'kode' => 'ADM-UMM', 'deskripsi' => 'Surat keterangan umum (SKU, SKTM, SKCK, dll)', 'urutan' => 2],
            ['nama' => 'Administrasi Nikah', 'kode' => 'ADM-NKH', 'deskripsi' => 'Surat pengantar nikah (N1, N2, N4)', 'urutan' => 3],
            ['nama' => 'Lain-lain', 'kode' => 'LAIN', 'deskripsi' => 'Surat lainnya', 'urutan' => 4],
        ];

        foreach ($kategoris as $kat) {
            SuratKategori::create($kat);
        }
        
        $this->command->info('   ✅ 4 Kategori created');
    }

    private function createJenisSurat()
    {
        $this->command->info('📄 Creating 20 Jenis Surat...');
        
        $kdp = SuratKategori::where('kode', 'ADM-KDP')->first()->id;
        $umm = SuratKategori::where('kode', 'ADM-UMM')->first()->id;
        $nkh = SuratKategori::where('kode', 'ADM-NKH')->first()->id;
        $lain = SuratKategori::where('kode', 'LAIN')->first()->id;

        $jenisSurat = [];

        // KATEGORI 1: ADMINISTRASI KEPENDUDUKAN (8 Surat)
        
        // 1. Surat Pengantar KTP
        $jenisSurat[] = [
            'kategori_id' => $kdp,
            'nama' => 'Surat Pengantar KTP',
            'kode' => 'SKT-KTP-001',
            'singkatan' => 'SP-KTP',
            'deskripsi' => 'Pengantar pembuatan atau perpanjangan Kartu Tanda Penduduk (KTP) ke Disdukcapil',
            'variabel' => [
                'nama_pemohon' => 'Nama lengkap pemohon',
                'nik' => 'NIK 16 digit',
                'tempat_lahir' => 'Tempat lahir',
                'tanggal_lahir' => 'Tanggal lahir',
                'jenis_kelamin' => 'Jenis kelamin (L/P)',
                'alamat' => 'Alamat lengkap',
                'rt' => 'RT',
                'rw' => 'RW',
                'dusun' => 'Dusun',
                'keperluan' => 'Keperluan (buat baru/perpanjangan)',
            ],
            'format_nomor' => '{nomor}/SKT-KTP/{romawi}/{tahun}',
            'perlu_ttd_kades' => true,
            'aktif_permohonan_online' => true,
            'aktif' => true,
            'urutan' => 1,
        ];

        // 2. Surat Pengantar Kartu Keluarga
        $jenisSurat[] = [
            'kategori_id' => $kdp,
            'nama' => 'Surat Pengantar Kartu Keluarga',
            'kode' => 'SKT-KK-002',
            'singkatan' => 'SP-KK',
            'deskripsi' => 'Pengantar pembuatan, pembaruan, atau pecah Kartu Keluarga',
            'variabel' => [
                'nama_kepala_keluarga' => 'Nama kepala keluarga',
                'nik_kepala_keluarga' => 'NIK kepala keluarga',
                'no_kk' => 'Nomor KK (jika ada)',
                'alamat' => 'Alamat lengkap',
                'rt' => 'RT',
                'rw' => 'RW',
                'dusun' => 'Dusun',
                'keperluan' => 'Keperluan (buat baru/pembaruan/pecah KK)',
                'jumlah_anggota' => 'Jumlah anggota keluarga',
            ],
            'format_nomor' => '{nomor}/SKT-KK/{romawi}/{tahun}',
            'perlu_ttd_kades' => true,
            'aktif_permohonan_online' => true,
            'aktif' => true,
            'urutan' => 2,
        ];

        // 3. Surat Keterangan Kelahiran
        $jenisSurat[] = [
            'kategori_id' => $kdp,
            'nama' => 'Surat Keterangan Kelahiran',
            'kode' => 'SKT-LHR-003',
            'singkatan' => 'SK-Lahir',
            'deskripsi' => 'Surat keterangan untuk pengurusan akta kelahiran anak',
            'variabel' => [
                'nama_bayi' => 'Nama bayi',
                'jenis_kelamin_bayi' => 'Jenis kelamin bayi (L/P)',
                'tempat_lahir' => 'Tempat lahir',
                'tanggal_lahir' => 'Tanggal lahir',
                'jam_lahir' => 'Jam lahir',
                'nama_ayah' => 'Nama ayah',
                'nik_ayah' => 'NIK ayah',
                'nama_ibu' => 'Nama ibu',
                'nik_ibu' => 'NIK ibu',
                'no_kk' => 'Nomor KK',
                'alamat' => 'Alamat',
            ],
            'format_nomor' => '{nomor}/SKT-LHR/{romawi}/{tahun}',
            'perlu_ttd_kades' => true,
            'aktif_permohonan_online' => true,
            'aktif' => true,
            'urutan' => 3,
        ];

        // 4. Surat Keterangan Kematian
        $jenisSurat[] = [
            'kategori_id' => $kdp,
            'nama' => 'Surat Keterangan Kematian',
            'kode' => 'SKT-MTI-004',
            'singkatan' => 'SK-Mati',
            'deskripsi' => 'Surat keterangan untuk administrasi kematian',
            'variabel' => [
                'nama_almarhum' => 'Nama yang meninggal',
                'nik_almarhum' => 'NIK almarhum',
                'tempat_lahir' => 'Tempat lahir',
                'tanggal_lahir' => 'Tanggal lahir',
                'umur' => 'Umur',
                'jenis_kelamin' => 'Jenis kelamin',
                'tanggal_meninggal' => 'Tanggal meninggal',
                'jam_meninggal' => 'Jam meninggal',
                'tempat_meninggal' => 'Tempat meninggal',
                'sebab_kematian' => 'Sebab kematian',
                'nama_pelapor' => 'Nama pelapor',
                'hubungan_pelapor' => 'Hubungan dengan almarhum',
            ],
            'format_nomor' => '{nomor}/SKT-MTI/{romawi}/{tahun}',
            'perlu_ttd_kades' => true,
            'aktif_permohonan_online' => false,
            'aktif' => true,
            'urutan' => 4,
        ];

        // 5. Surat Keterangan Pindah
        $jenisSurat[] = [
            'kategori_id' => $kdp,
            'nama' => 'Surat Keterangan Pindah',
            'kode' => 'SKT-PND-005',
            'singkatan' => 'SK-Pindah',
            'deskripsi' => 'Surat keterangan untuk warga yang akan pindah ke luar wilayah desa',
            'variabel' => [
                'nama_pemohon' => 'Nama',
                'nik' => 'NIK',
                'no_kk' => 'Nomor KK',
                'alamat_asal' => 'Alamat asal',
                'alamat_tujuan' => 'Alamat tujuan',
                'alasan_pindah' => 'Alasan pindah',
                'jumlah_keluarga_pindah' => 'Jumlah yang pindah',
                'tanggal_pindah' => 'Tanggal pindah',
            ],
            'format_nomor' => '{nomor}/SKT-PND/{romawi}/{tahun}',
            'perlu_ttd_kades' => true,
            'aktif_permohonan_online' => true,
            'aktif' => true,
            'urutan' => 5,
        ];

        // 6. Surat Keterangan Datang
        $jenisSurat[] = [
            'kategori_id' => $kdp,
            'nama' => 'Surat Keterangan Datang',
            'kode' => 'SKT-DTG-006',
            'singkatan' => 'SK-Datang',
            'deskripsi' => 'Surat keterangan untuk warga yang pindah masuk ke wilayah desa',
            'variabel' => [
                'nama_pemohon' => 'Nama',
                'nik' => 'NIK',
                'no_kk' => 'Nomor KK',
                'alamat_asal' => 'Alamat asal',
                'alamat_tujuan' => 'Alamat tujuan di desa',
                'alasan_pindah' => 'Alasan pindah',
                'tanggal_datang' => 'Tanggal datang',
            ],
            'format_nomor' => '{nomor}/SKT-DTG/{romawi}/{tahun}',
            'perlu_ttd_kades' => true,
            'aktif_permohonan_online' => false,
            'aktif' => true,
            'urutan' => 6,
        ];

        // 7. Surat Keterangan Domisili
        $jenisSurat[] = [
            'kategori_id' => $kdp,
            'nama' => 'Surat Keterangan Domisili',
            'kode' => 'SKT-DOM-007',
            'singkatan' => 'SKD',
            'deskripsi' => 'Surat keterangan bahwa seseorang berdomisili di wilayah Desa',
            'variabel' => [
                'nama_pemohon' => 'Nama',
                'nik' => 'NIK',
                'tempat_lahir' => 'Tempat lahir',
                'tanggal_lahir' => 'Tanggal lahir',
                'jenis_kelamin' => 'Jenis kelamin',
                'pekerjaan' => 'Pekerjaan',
                'alamat' => 'Alamat lengkap',
                'rt' => 'RT',
                'rw' => 'RW',
                'dusun' => 'Dusun',
                'keperluan' => 'Keperluan',
            ],
            'format_nomor' => '{nomor}/SKT-DOM/{romawi}/{tahun}',
            'perlu_ttd_kades' => true,
            'aktif_permohonan_online' => true,
            'aktif' => true,
            'urutan' => 7,
        ];

        // 8. Surat Keterangan Belum Menikah
        $jenisSurat[] = [
            'kategori_id' => $kdp,
            'nama' => 'Surat Keterangan Belum Menikah',
            'kode' => 'SKT-BLM-008',
            'singkatan' => 'SK-Belum Nikah',
            'deskripsi' => 'Surat keterangan status belum menikah',
            'variabel' => [
                'nama_pemohon' => 'Nama',
                'nik' => 'NIK',
                'tempat_lahir' => 'Tempat lahir',
                'tanggal_lahir' => 'Tanggal lahir',
                'jenis_kelamin' => 'Jenis kelamin',
                'agama' => 'Agama',
                'pekerjaan' => 'Pekerjaan',
                'alamat' => 'Alamat',
                'keperluan' => 'Keperluan',
            ],
            'format_nomor' => '{nomor}/SKT-BLM/{romawi}/{tahun}',
            'perlu_ttd_kades' => true,
            'aktif_permohonan_online' => true,
            'aktif' => true,
            'urutan' => 8,
        ];

        // KATEGORI 2: ADMINISTRASI UMUM (7 Surat)
        
        // 9. Surat Keterangan Usaha (SKU)
        $jenisSurat[] = [
            'kategori_id' => $umm,
            'nama' => 'Surat Keterangan Usaha',
            'kode' => 'SKT-USH-009',
            'singkatan' => 'SKU',
            'deskripsi' => 'Surat keterangan untuk pelaku usaha mikro dan kecil di wilayah desa',
            'variabel' => [
                'nama_pemohon' => 'Nama pemilik',
                'nik' => 'NIK',
                'tempat_lahir' => 'Tempat lahir',
                'tanggal_lahir' => 'Tanggal lahir',
                'pekerjaan' => 'Pekerjaan',
                'alamat' => 'Alamat',
                'nama_usaha' => 'Nama usaha',
                'jenis_usaha' => 'Jenis usaha',
                'alamat_usaha' => 'Alamat usaha',
                'tahun_berdiri' => 'Tahun berdiri',
                'keperluan' => 'Keperluan',
            ],
            'format_nomor' => '{nomor}/SKT-USH/{romawi}/{tahun}',
            'perlu_ttd_kades' => true,
            'aktif_permohonan_online' => true,
            'aktif' => true,
            'urutan' => 9,
        ];

        // 10. Surat Keterangan Tidak Mampu (SKTM)
        $jenisSurat[] = [
            'kategori_id' => $umm,
            'nama' => 'Surat Keterangan Tidak Mampu',
            'kode' => 'SKT-TDM-010',
            'singkatan' => 'SKTM',
            'deskripsi' => 'Surat keterangan untuk keperluan keringanan biaya pendidikan, kesehatan, atau bantuan sosial',
            'variabel' => [
                'nama_pemohon' => 'Nama',
                'nik' => 'NIK',
                'tempat_lahir' => 'Tempat lahir',
                'tanggal_lahir' => 'Tanggal lahir',
                'jenis_kelamin' => 'Jenis kelamin',
                'pekerjaan' => 'Pekerjaan',
                'alamat' => 'Alamat',
                'penghasilan' => 'Penghasilan per bulan',
                'jumlah_tanggungan' => 'Jumlah tanggungan',
                'keperluan' => 'Keperluan (pendidikan/kesehatan/bantuan sosial)',
            ],
            'format_nomor' => '{nomor}/SKT-TDM/{romawi}/{tahun}',
            'perlu_ttd_kades' => true,
            'aktif_permohonan_online' => true,
            'aktif' => true,
            'urutan' => 10,
        ];

        // 11. Surat Keterangan Penghasilan
        $jenisSurat[] = [
            'kategori_id' => $umm,
            'nama' => 'Surat Keterangan Penghasilan',
            'kode' => 'SKT-PGH-011',
            'singkatan' => 'SK-Penghasilan',
            'deskripsi' => 'Surat keterangan penghasilan',
            'variabel' => [
                'nama_pemohon' => 'Nama',
                'nik' => 'NIK',
                'tempat_lahir' => 'Tempat lahir',
                'tanggal_lahir' => 'Tanggal lahir',
                'pekerjaan' => 'Pekerjaan',
                'alamat' => 'Alamat',
                'penghasilan_perbulan' => 'Penghasilan per bulan',
                'sumber_penghasilan' => 'Sumber penghasilan',
                'keperluan' => 'Keperluan',
            ],
            'format_nomor' => '{nomor}/SKT-PGH/{romawi}/{tahun}',
            'perlu_ttd_kades' => true,
            'aktif_permohonan_online' => true,
            'aktif' => true,
            'urutan' => 11,
        ];

        // 12. Surat Keterangan Ahli Waris
        $jenisSurat[] = [
            'kategori_id' => $umm,
            'nama' => 'Surat Keterangan Ahli Waris',
            'kode' => 'SKT-AHW-012',
            'singkatan' => 'SK-Ahli Waris',
            'deskripsi' => 'Surat keterangan ahli waris',
            'variabel' => [
                'nama_almarhum' => 'Nama yang meninggal',
                'nik_almarhum' => 'NIK almarhum',
                'tanggal_meninggal' => 'Tanggal meninggal',
                'alamat_almarhum' => 'Alamat almarhum',
                'nama_pemohon' => 'Nama pemohon',
                'hubungan_pemohon' => 'Hubungan dengan almarhum',
                'keperluan' => 'Keperluan',
            ],
            'field_tambahan' => [
                'daftar_ahli_waris' => 'textarea',
            ],
            'format_nomor' => '{nomor}/SKT-AHW/{romawi}/{tahun}',
            'perlu_ttd_kades' => true,
            'aktif_permohonan_online' => false,
            'aktif' => true,
            'urutan' => 12,
        ];

        // 13. Surat Keterangan Kehilangan
        $jenisSurat[] = [
            'kategori_id' => $umm,
            'nama' => 'Surat Keterangan Kehilangan',
            'kode' => 'SKT-HLG-013',
            'singkatan' => 'SK-Hilang',
            'deskripsi' => 'Surat keterangan kehilangan barang/dokumen',
            'variabel' => [
                'nama_pemohon' => 'Nama',
                'nik' => 'NIK',
                'alamat' => 'Alamat',
                'barang_hilang' => 'Barang yang hilang',
                'ciri_ciri' => 'Ciri-ciri barang',
                'tempat_hilang' => 'Tempat hilang',
                'tanggal_hilang' => 'Tanggal hilang',
                'kronologi' => 'Kronologi kejadian',
                'keperluan' => 'Keperluan',
            ],
            'format_nomor' => '{nomor}/SKT-HLG/{romawi}/{tahun}',
            'perlu_ttd_kades' => true,
            'aktif_permohonan_online' => true,
            'aktif' => true,
            'urutan' => 13,
        ];

        // 14. Surat Keterangan Jalan
        $jenisSurat[] = [
            'kategori_id' => $umm,
            'nama' => 'Surat Keterangan Jalan',
            'kode' => 'SKT-JLN-014',
            'singkatan' => 'SK-Jalan',
            'deskripsi' => 'Surat keterangan untuk izin membawa barang/kendaraan',
            'variabel' => [
                'nama_pemohon' => 'Nama',
                'nik' => 'NIK',
                'alamat' => 'Alamat',
                'jenis_barang' => 'Jenis barang',
                'jumlah' => 'Jumlah',
                'tujuan' => 'Tujuan',
                'keperluan' => 'Keperluan',
            ],
            'format_nomor' => '{nomor}/SKT-JLN/{romawi}/{tahun}',
            'perlu_ttd_kades' => true,
            'aktif_permohonan_online' => true,
            'aktif' => true,
            'urutan' => 14,
        ];

        // 15. Surat Pengantar SKCK
        $jenisSurat[] = [
            'kategori_id' => $umm,
            'nama' => 'Surat Pengantar SKCK',
            'kode' => 'SKT-SKCK-015',
            'singkatan' => 'SP-SKCK',
            'deskripsi' => 'Surat pengantar pembuatan SKCK ke kepolisian setempat',
            'variabel' => [
                'nama_pemohon' => 'Nama',
                'nik' => 'NIK',
                'tempat_lahir' => 'Tempat lahir',
                'tanggal_lahir' => 'Tanggal lahir',
                'jenis_kelamin' => 'Jenis kelamin',
                'agama' => 'Agama',
                'pekerjaan' => 'Pekerjaan',
                'alamat' => 'Alamat',
                'keperluan' => 'Keperluan',
            ],
            'format_nomor' => '{nomor}/SKT-SKCK/{romawi}/{tahun}',
            'perlu_ttd_kades' => true,
            'aktif_permohonan_online' => true,
            'aktif' => true,
            'urutan' => 15,
        ];

        // KATEGORI 3: ADMINISTRASI NIKAH (3 Surat)
        
        // 16. Surat Pengantar Nikah (N1)
        $jenisSurat[] = [
            'kategori_id' => $nkh,
            'nama' => 'Surat Pengantar Nikah (N1)',
            'kode' => 'SKT-N1-016',
            'singkatan' => 'N1',
            'deskripsi' => 'Surat pengantar untuk pengurusan pernikahan di KUA atau Catatan Sipil',
            'variabel' => [
                'nama_calon_suami' => 'Nama calon suami',
                'nik_calon_suami' => 'NIK calon suami',
                'tempat_lahir_suami' => 'Tempat lahir suami',
                'tanggal_lahir_suami' => 'Tanggal lahir suami',
                'agama_suami' => 'Agama suami',
                'pekerjaan_suami' => 'Pekerjaan suami',
                'alamat_suami' => 'Alamat suami',
                'status_suami' => 'Status (jejaka/duda)',
                'nama_calon_istri' => 'Nama calon istri',
                'nik_calon_istri' => 'NIK calon istri',
                'tempat_lahir_istri' => 'Tempat lahir istri',
                'tanggal_lahir_istri' => 'Tanggal lahir istri',
                'agama_istri' => 'Agama istri',
                'pekerjaan_istri' => 'Pekerjaan istri',
                'alamat_istri' => 'Alamat istri',
                'status_istri' => 'Status (perawan/janda)',
            ],
            'format_nomor' => '{nomor}/N1/{romawi}/{tahun}',
            'perlu_ttd_kades' => true,
            'aktif_permohonan_online' => true,
            'aktif' => true,
            'urutan' => 16,
        ];

        // 17. Surat Keterangan Untuk Nikah (N2)
        $jenisSurat[] = [
            'kategori_id' => $nkh,
            'nama' => 'Surat Keterangan Untuk Nikah (N2)',
            'kode' => 'SKT-N2-017',
            'singkatan' => 'N2',
            'deskripsi' => 'Surat keterangan belum pernah menikah untuk keperluan nikah',
            'variabel' => [
                'nama_pemohon' => 'Nama',
                'nik' => 'NIK',
                'tempat_lahir' => 'Tempat lahir',
                'tanggal_lahir' => 'Tanggal lahir',
                'agama' => 'Agama',
                'pekerjaan' => 'Pekerjaan',
                'alamat' => 'Alamat',
                'status' => 'Status (jejaka/perawan/duda/janda)',
            ],
            'format_nomor' => '{nomor}/N2/{romawi}/{tahun}',
            'perlu_ttd_kades' => true,
            'aktif_permohonan_online' => true,
            'aktif' => true,
            'urutan' => 17,
        ];

        // 18. Surat Keterangan Asal Usul (N4)
        $jenisSurat[] = [
            'kategori_id' => $nkh,
            'nama' => 'Surat Keterangan Asal Usul (N4)',
            'kode' => 'SKT-N4-018',
            'singkatan' => 'N4',
            'deskripsi' => 'Surat keterangan asal usul untuk keperluan nikah',
            'variabel' => [
                'nama_pemohon' => 'Nama',
                'nik' => 'NIK',
                'tempat_lahir' => 'Tempat lahir',
                'tanggal_lahir' => 'Tanggal lahir',
                'nama_ayah' => 'Nama ayah',
                'nama_ibu' => 'Nama ibu',
                'alamat' => 'Alamat',
            ],
            'format_nomor' => '{nomor}/N4/{romawi}/{tahun}',
            'perlu_ttd_kades' => true,
            'aktif_permohonan_online' => true,
            'aktif' => true,
            'urutan' => 18,
        ];

        // KATEGORI 4: LAIN-LAIN (2 Surat)
        
        // 19. Surat Keterangan Umum
        $jenisSurat[] = [
            'kategori_id' => $lain,
            'nama' => 'Surat Keterangan Umum',
            'kode' => 'SKT-UMM-019',
            'singkatan' => 'SK-Umum',
            'deskripsi' => 'Surat keterangan umum untuk berbagai keperluan',
            'variabel' => [
                'nama_pemohon' => 'Nama',
                'nik' => 'NIK',
                'tempat_lahir' => 'Tempat lahir',
                'tanggal_lahir' => 'Tanggal lahir',
                'jenis_kelamin' => 'Jenis kelamin',
                'agama' => 'Agama',
                'pekerjaan' => 'Pekerjaan',
                'alamat' => 'Alamat',
                'keterangan' => 'Keterangan yang diminta',
                'keperluan' => 'Keperluan',
            ],
            'format_nomor' => '{nomor}/SKT-UMM/{romawi}/{tahun}',
            'perlu_ttd_kades' => true,
            'aktif_permohonan_online' => true,
            'aktif' => true,
            'urutan' => 19,
        ];

        // 20. Surat Kuasa
        $jenisSurat[] = [
            'kategori_id' => $lain,
            'nama' => 'Surat Kuasa',
            'kode' => 'SKT-KUA-020',
            'singkatan' => 'SK-Kuasa',
            'deskripsi' => 'Surat pemberian kuasa',
            'variabel' => [
                'nama_pemberi_kuasa' => 'Nama pemberi kuasa',
                'nik_pemberi_kuasa' => 'NIK pemberi kuasa',
                'alamat_pemberi_kuasa' => 'Alamat pemberi kuasa',
                'nama_penerima_kuasa' => 'Nama penerima kuasa',
                'nik_penerima_kuasa' => 'NIK penerima kuasa',
                'alamat_penerima_kuasa' => 'Alamat penerima kuasa',
                'keperluan_kuasa' => 'Keperluan kuasa',
                'masa_berlaku' => 'Masa berlaku',
            ],
            'format_nomor' => '{nomor}/SKT-KUA/{romawi}/{tahun}',
            'perlu_ttd_kades' => true,
            'aktif_permohonan_online' => false,
            'aktif' => true,
            'urutan' => 20,
        ];

        // Insert all
        foreach ($jenisSurat as $surat) {
            SuratJenis::create($surat);
        }
        
        $this->command->info('   ✅ 20 Jenis Surat created');
    }
}
