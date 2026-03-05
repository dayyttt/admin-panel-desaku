<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SuratKategori;
use App\Models\SuratJenis;

class SuratJenisTambahanSeeder extends Seeder
{
    /**
     * Seeder untuk menambahkan 25 jenis surat tambahan (21-45)
     * Jalankan dengan: php artisan db:seed --class=SuratJenisTambahanSeeder
     */
    
    private function createKategoriBaru()
    {
        $this->command->info('📁 Creating 3 Kategori Baru...');
        
        $kategoriBaru = [
            ['nama' => 'Pertanahan', 'kode' => 'ADM-TNH', 'deskripsi' => 'Surat terkait tanah dan properti', 'urutan' => 4],
            ['nama' => 'Bantuan & Sosial', 'kode' => 'ADM-BNT', 'deskripsi' => 'Surat rekomendasi bantuan sosial, BPJS, beasiswa, UMKM', 'urutan' => 5],
            ['nama' => 'Khusus & Lainnya', 'kode' => 'ADM-KHS', 'deskripsi' => 'Surat izin keramaian, IMB, rekomendasi kegiatan', 'urutan' => 6],
        ];

        foreach ($kategoriBaru as $kat) {
            SuratKategori::firstOrCreate(
                ['kode' => $kat['kode']],
                $kat
            );
        }
        
        // Update urutan kategori Lain-lain
        SuratKategori::where('kode', 'LAIN')->update(['urutan' => 7]);
        
        $this->command->info('   ✅ 3 Kategori baru created/updated');
        $this->command->newLine();
    }
    
    public function run(): void
    {
        $this->command->info('🌱 Adding 25 Jenis Surat Tambahan...');
        $this->command->newLine();

        // Buat kategori baru jika belum ada
        $this->createKategoriBaru();

        $kdp = SuratKategori::where('kode', 'ADM-KDP')->first()->id;
        $umm = SuratKategori::where('kode', 'ADM-UMM')->first()->id;
        $nkh = SuratKategori::where('kode', 'ADM-NKH')->first()->id;
        $tnh = SuratKategori::where('kode', 'ADM-TNH')->first()->id;
        $bnt = SuratKategori::where('kode', 'ADM-BNT')->first()->id;
        $khs = SuratKategori::where('kode', 'ADM-KHS')->first()->id;

        $jenisSurat = [];

        // KATEGORI 1: ADMINISTRASI KEPENDUDUKAN - TAMBAHAN (5 Surat)
        
        // 21. Surat Keterangan Status (Janda/Duda)
        $jenisSurat[] = [
            'kategori_id' => $kdp,
            'nama' => 'Surat Keterangan Status (Janda/Duda)',
            'kode' => 'SKT-STS-021',
            'singkatan' => 'SK-Status',
            'deskripsi' => 'Surat keterangan status janda atau duda',
            'variabel' => [
                'nama_pemohon' => 'Nama',
                'nik' => 'NIK',
                'tempat_lahir' => 'Tempat lahir',
                'tanggal_lahir' => 'Tanggal lahir',
                'status' => 'Status (janda/duda)',
                'nama_pasangan_almarhum' => 'Nama pasangan yang meninggal/cerai',
                'tanggal_cerai_meninggal' => 'Tanggal cerai/meninggal',
                'alamat' => 'Alamat',
                'keperluan' => 'Keperluan',
            ],
            'format_nomor' => '{nomor}/SKT-STS/{romawi}/{tahun}',
            'perlu_ttd_kades' => true,
            'aktif_permohonan_online' => true,
            'aktif' => true,
            'urutan' => 21,
        ];

        // 22. Surat Keterangan Penduduk Sementara
        $jenisSurat[] = [
            'kategori_id' => $kdp,
            'nama' => 'Surat Keterangan Penduduk Sementara',
            'kode' => 'SKT-PDS-022',
            'singkatan' => 'SK-Penduduk Sementara',
            'deskripsi' => 'Surat keterangan untuk penduduk yang tinggal sementara',
            'variabel' => [
                'nama_pemohon' => 'Nama',
                'nik' => 'NIK',
                'tempat_lahir' => 'Tempat lahir',
                'tanggal_lahir' => 'Tanggal lahir',
                'alamat_asal' => 'Alamat asal',
                'alamat_sementara' => 'Alamat sementara di desa',
                'lama_tinggal' => 'Lama tinggal',
                'keperluan' => 'Keperluan',
            ],
            'format_nomor' => '{nomor}/SKT-PDS/{romawi}/{tahun}',
            'perlu_ttd_kades' => true,
            'aktif_permohonan_online' => true,
            'aktif' => true,
            'urutan' => 22,
        ];

        // 23. Surat Keterangan Beda Nama
        $jenisSurat[] = [
            'kategori_id' => $kdp,
            'nama' => 'Surat Keterangan Beda Nama',
            'kode' => 'SKT-BDN-023',
            'singkatan' => 'SK-Beda Nama',
            'deskripsi' => 'Surat keterangan untuk perbedaan nama di dokumen',
            'variabel' => [
                'nama_pemohon' => 'Nama sekarang',
                'nik' => 'NIK',
                'nama_lama' => 'Nama di dokumen lama',
                'nama_baru' => 'Nama di dokumen baru',
                'dokumen_lama' => 'Dokumen yang berbeda',
                'alasan' => 'Alasan perbedaan',
                'alamat' => 'Alamat',
                'keperluan' => 'Keperluan',
            ],
            'format_nomor' => '{nomor}/SKT-BDN/{romawi}/{tahun}',
            'perlu_ttd_kades' => true,
            'aktif_permohonan_online' => true,
            'aktif' => true,
            'urutan' => 23,
        ];

        // 24. Surat Pindah Masuk
        $jenisSurat[] = [
            'kategori_id' => $kdp,
            'nama' => 'Surat Pindah Masuk',
            'kode' => 'SKT-PDM-024',
            'singkatan' => 'SP-Masuk',
            'deskripsi' => 'Surat keterangan pindah masuk ke wilayah desa',
            'variabel' => [
                'nama_pemohon' => 'Nama kepala keluarga',
                'nik' => 'NIK',
                'no_kk' => 'Nomor KK',
                'alamat_asal' => 'Alamat asal',
                'alamat_tujuan' => 'Alamat tujuan di desa',
                'jumlah_keluarga' => 'Jumlah anggota keluarga',
                'tanggal_pindah' => 'Tanggal pindah',
            ],
            'format_nomor' => '{nomor}/SKT-PDM/{romawi}/{tahun}',
            'perlu_ttd_kades' => true,
            'aktif_permohonan_online' => true,
            'aktif' => true,
            'urutan' => 24,
        ];

        // 25. Surat Keterangan Ahli Waris (pindah dari kategori umum)
        $jenisSurat[] = [
            'kategori_id' => $kdp,
            'nama' => 'Surat Keterangan Ahli Waris',
            'kode' => 'SKT-AHW-025',
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
            'field_tambahan' => ['daftar_ahli_waris' => 'textarea'],
            'format_nomor' => '{nomor}/SKT-AHW/{romawi}/{tahun}',
            'perlu_ttd_kades' => true,
            'aktif_permohonan_online' => false,
            'aktif' => true,
            'urutan' => 25,
        ];

        // KATEGORI 2: ADMINISTRASI UMUM - TAMBAHAN (4 Surat)
        
        // 26. Surat Rekomendasi Umum
        $jenisSurat[] = [
            'kategori_id' => $umm,
            'nama' => 'Surat Rekomendasi Umum',
            'kode' => 'SKT-RKM-026',
            'singkatan' => 'SR-Umum',
            'deskripsi' => 'Surat rekomendasi untuk berbagai keperluan',
            'variabel' => [
                'nama_pemohon' => 'Nama',
                'nik' => 'NIK',
                'alamat' => 'Alamat',
                'keperluan' => 'Keperluan rekomendasi',
                'tujuan' => 'Ditujukan kepada',
            ],
            'format_nomor' => '{nomor}/SKT-RKM/{romawi}/{tahun}',
            'perlu_ttd_kades' => true,
            'aktif_permohonan_online' => true,
            'aktif' => true,
            'urutan' => 26,
        ];

        // 27. Surat Pengantar Proposal
        $jenisSurat[] = [
            'kategori_id' => $umm,
            'nama' => 'Surat Pengantar Proposal',
            'kode' => 'SKT-PRP-027',
            'singkatan' => 'SP-Proposal',
            'deskripsi' => 'Surat pengantar untuk pengajuan proposal',
            'variabel' => [
                'nama_pemohon' => 'Nama pemohon',
                'organisasi' => 'Nama organisasi',
                'judul_proposal' => 'Judul proposal',
                'tujuan' => 'Tujuan proposal',
                'alamat' => 'Alamat',
            ],
            'format_nomor' => '{nomor}/SKT-PRP/{romawi}/{tahun}',
            'perlu_ttd_kades' => true,
            'aktif_permohonan_online' => true,
            'aktif' => true,
            'urutan' => 27,
        ];

        // 28. Surat Keterangan Tanggungan Keluarga
        $jenisSurat[] = [
            'kategori_id' => $umm,
            'nama' => 'Surat Keterangan Tanggungan Keluarga',
            'kode' => 'SKT-TGG-028',
            'singkatan' => 'SK-Tanggungan',
            'deskripsi' => 'Surat keterangan jumlah tanggungan keluarga',
            'variabel' => [
                'nama_pemohon' => 'Nama',
                'nik' => 'NIK',
                'pekerjaan' => 'Pekerjaan',
                'alamat' => 'Alamat',
                'jumlah_tanggungan' => 'Jumlah tanggungan',
                'keperluan' => 'Keperluan',
            ],
            'format_nomor' => '{nomor}/SKT-TGG/{romawi}/{tahun}',
            'perlu_ttd_kades' => true,
            'aktif_permohonan_online' => true,
            'aktif' => true,
            'urutan' => 28,
        ];

        // 29. Surat Keterangan Belum Bekerja
        $jenisSurat[] = [
            'kategori_id' => $umm,
            'nama' => 'Surat Keterangan Belum Bekerja',
            'kode' => 'SKT-BBK-029',
            'singkatan' => 'SK-Belum Bekerja',
            'deskripsi' => 'Surat keterangan belum bekerja',
            'variabel' => [
                'nama_pemohon' => 'Nama',
                'nik' => 'NIK',
                'tempat_lahir' => 'Tempat lahir',
                'tanggal_lahir' => 'Tanggal lahir',
                'pendidikan' => 'Pendidikan terakhir',
                'alamat' => 'Alamat',
                'keperluan' => 'Keperluan',
            ],
            'format_nomor' => '{nomor}/SKT-BBK/{romawi}/{tahun}',
            'perlu_ttd_kades' => true,
            'aktif_permohonan_online' => true,
            'aktif' => true,
            'urutan' => 29,
        ];

        // KATEGORI 3: ADMINISTRASI NIKAH - TAMBAHAN (3 Surat)
        
        // 30. Surat Pernyataan Belum Menikah
        $jenisSurat[] = [
            'kategori_id' => $nkh,
            'nama' => 'Surat Pernyataan Belum Menikah',
            'kode' => 'SKT-PBM-030',
            'singkatan' => 'Pernyataan Belum Nikah',
            'deskripsi' => 'Surat pernyataan belum pernah menikah',
            'variabel' => [
                'nama_pemohon' => 'Nama',
                'nik' => 'NIK',
                'tempat_lahir' => 'Tempat lahir',
                'tanggal_lahir' => 'Tanggal lahir',
                'agama' => 'Agama',
                'alamat' => 'Alamat',
                'keperluan' => 'Keperluan',
            ],
            'format_nomor' => '{nomor}/SKT-PBM/{romawi}/{tahun}',
            'perlu_ttd_kades' => true,
            'aktif_permohonan_online' => true,
            'aktif' => true,
            'urutan' => 30,
        ];

        // 31. Surat Pengantar Cerai
        $jenisSurat[] = [
            'kategori_id' => $nkh,
            'nama' => 'Surat Pengantar Cerai',
            'kode' => 'SKT-CRI-031',
            'singkatan' => 'SP-Cerai',
            'deskripsi' => 'Surat pengantar untuk proses perceraian',
            'variabel' => [
                'nama_pemohon' => 'Nama',
                'nik' => 'NIK',
                'nama_pasangan' => 'Nama pasangan',
                'tanggal_menikah' => 'Tanggal menikah',
                'alasan' => 'Alasan perceraian',
                'alamat' => 'Alamat',
            ],
            'format_nomor' => '{nomor}/SKT-CRI/{romawi}/{tahun}',
            'perlu_ttd_kades' => true,
            'aktif_permohonan_online' => false,
            'aktif' => true,
            'urutan' => 31,
        ];

        // 32. Surat Keterangan Izin Orang Tua
        $jenisSurat[] = [
            'kategori_id' => $nkh,
            'nama' => 'Surat Keterangan Izin Orang Tua',
            'kode' => 'SKT-IOP-032',
            'singkatan' => 'Izin Ortu',
            'deskripsi' => 'Surat izin orang tua untuk menikah',
            'variabel' => [
                'nama_anak' => 'Nama anak',
                'nik_anak' => 'NIK anak',
                'nama_ayah' => 'Nama ayah',
                'nama_ibu' => 'Nama ibu',
                'alamat' => 'Alamat',
                'keperluan' => 'Keperluan',
            ],
            'format_nomor' => '{nomor}/SKT-IOP/{romawi}/{tahun}',
            'perlu_ttd_kades' => true,
            'aktif_permohonan_online' => true,
            'aktif' => true,
            'urutan' => 32,
        ];

        // KATEGORI 4: PERTANAHAN (5 Surat)
        
        // 33. Surat Keterangan Tanah (SKT)
        $jenisSurat[] = [
            'kategori_id' => $tnh,
            'nama' => 'Surat Keterangan Tanah (SKT)',
            'kode' => 'SKT-TNH-033',
            'singkatan' => 'SKT',
            'deskripsi' => 'Surat keterangan kepemilikan tanah',
            'variabel' => [
                'nama_pemilik' => 'Nama pemilik',
                'nik' => 'NIK',
                'lokasi_tanah' => 'Lokasi tanah',
                'luas_tanah' => 'Luas tanah',
                'batas_utara' => 'Batas utara',
                'batas_selatan' => 'Batas selatan',
                'batas_timur' => 'Batas timur',
                'batas_barat' => 'Batas barat',
                'keperluan' => 'Keperluan',
            ],
            'format_nomor' => '{nomor}/SKT-TNH/{romawi}/{tahun}',
            'perlu_ttd_kades' => true,
            'aktif_permohonan_online' => true,
            'aktif' => true,
            'urutan' => 33,
        ];

        // 34. Surat Sporadik
        $jenisSurat[] = [
            'kategori_id' => $tnh,
            'nama' => 'Surat Sporadik',
            'kode' => 'SKT-SPR-034',
            'singkatan' => 'Sporadik',
            'deskripsi' => 'Surat keterangan untuk pendaftaran tanah sporadik',
            'variabel' => [
                'nama_pemilik' => 'Nama pemilik',
                'nik' => 'NIK',
                'lokasi_tanah' => 'Lokasi tanah',
                'luas_tanah' => 'Luas tanah',
                'nomor_persil' => 'Nomor persil',
                'kelas_tanah' => 'Kelas tanah',
                'keperluan' => 'Keperluan',
            ],
            'format_nomor' => '{nomor}/SKT-SPR/{romawi}/{tahun}',
            'perlu_ttd_kades' => true,
            'aktif_permohonan_online' => true,
            'aktif' => true,
            'urutan' => 34,
        ];

        // 35. Surat Keterangan Riwayat Tanah
        $jenisSurat[] = [
            'kategori_id' => $tnh,
            'nama' => 'Surat Keterangan Riwayat Tanah',
            'kode' => 'SKT-RWT-035',
            'singkatan' => 'SK-Riwayat Tanah',
            'deskripsi' => 'Surat keterangan riwayat kepemilikan tanah',
            'variabel' => [
                'nama_pemilik' => 'Nama pemilik sekarang',
                'nik' => 'NIK',
                'lokasi_tanah' => 'Lokasi tanah',
                'luas_tanah' => 'Luas tanah',
                'pemilik_sebelumnya' => 'Pemilik sebelumnya',
                'tahun_perolehan' => 'Tahun perolehan',
                'cara_perolehan' => 'Cara perolehan',
                'keperluan' => 'Keperluan',
            ],
            'format_nomor' => '{nomor}/SKT-RWT/{romawi}/{tahun}',
            'perlu_ttd_kades' => true,
            'aktif_permohonan_online' => true,
            'aktif' => true,
            'urutan' => 35,
        ];

        // 36. Surat Pernyataan Penguasaan Tanah
        $jenisSurat[] = [
            'kategori_id' => $tnh,
            'nama' => 'Surat Pernyataan Penguasaan Tanah',
            'kode' => 'SKT-PPT-036',
            'singkatan' => 'Pernyataan Tanah',
            'deskripsi' => 'Surat pernyataan penguasaan fisik tanah',
            'variabel' => [
                'nama_pemilik' => 'Nama',
                'nik' => 'NIK',
                'lokasi_tanah' => 'Lokasi tanah',
                'luas_tanah' => 'Luas tanah',
                'lama_menguasai' => 'Lama menguasai',
                'cara_perolehan' => 'Cara perolehan',
                'keperluan' => 'Keperluan',
            ],
            'format_nomor' => '{nomor}/SKT-PPT/{romawi}/{tahun}',
            'perlu_ttd_kades' => true,
            'aktif_permohonan_online' => true,
            'aktif' => true,
            'urutan' => 36,
        ];

        // 37. Surat Keterangan Jual Beli Tanah
        $jenisSurat[] = [
            'kategori_id' => $tnh,
            'nama' => 'Surat Keterangan Jual Beli Tanah',
            'kode' => 'SKT-JBT-037',
            'singkatan' => 'SK-Jual Beli',
            'deskripsi' => 'Surat keterangan transaksi jual beli tanah',
            'variabel' => [
                'nama_penjual' => 'Nama penjual',
                'nik_penjual' => 'NIK penjual',
                'nama_pembeli' => 'Nama pembeli',
                'nik_pembeli' => 'NIK pembeli',
                'lokasi_tanah' => 'Lokasi tanah',
                'luas_tanah' => 'Luas tanah',
                'harga' => 'Harga jual beli',
                'tanggal_transaksi' => 'Tanggal transaksi',
            ],
            'format_nomor' => '{nomor}/SKT-JBT/{romawi}/{tahun}',
            'perlu_ttd_kades' => true,
            'aktif_permohonan_online' => false,
            'aktif' => true,
            'urutan' => 37,
        ];

        // KATEGORI 5: BANTUAN & SOSIAL (5 Surat)
        
        // 38. Surat Pengantar BPJS
        $jenisSurat[] = [
            'kategori_id' => $bnt,
            'nama' => 'Surat Pengantar BPJS',
            'kode' => 'SKT-BPJ-038',
            'singkatan' => 'SP-BPJS',
            'deskripsi' => 'Surat pengantar untuk pendaftaran BPJS',
            'variabel' => [
                'nama_pemohon' => 'Nama',
                'nik' => 'NIK',
                'alamat' => 'Alamat',
                'jenis_bpjs' => 'Jenis BPJS (Kesehatan/Ketenagakerjaan)',
                'keperluan' => 'Keperluan',
            ],
            'format_nomor' => '{nomor}/SKT-BPJ/{romawi}/{tahun}',
            'perlu_ttd_kades' => true,
            'aktif_permohonan_online' => true,
            'aktif' => true,
            'urutan' => 38,
        ];

        // 39. Surat Rekomendasi Bantuan Sosial
        $jenisSurat[] = [
            'kategori_id' => $bnt,
            'nama' => 'Surat Rekomendasi Bantuan Sosial',
            'kode' => 'SKT-BNS-039',
            'singkatan' => 'Rekomendasi Bansos',
            'deskripsi' => 'Surat rekomendasi untuk penerima bantuan sosial',
            'variabel' => [
                'nama_pemohon' => 'Nama',
                'nik' => 'NIK',
                'alamat' => 'Alamat',
                'pekerjaan' => 'Pekerjaan',
                'penghasilan' => 'Penghasilan',
                'jumlah_tanggungan' => 'Jumlah tanggungan',
                'jenis_bantuan' => 'Jenis bantuan yang diajukan',
            ],
            'format_nomor' => '{nomor}/SKT-BNS/{romawi}/{tahun}',
            'perlu_ttd_kades' => true,
            'aktif_permohonan_online' => true,
            'aktif' => true,
            'urutan' => 39,
        ];

        // 40. Surat Pengantar Beasiswa
        $jenisSurat[] = [
            'kategori_id' => $bnt,
            'nama' => 'Surat Pengantar Beasiswa',
            'kode' => 'SKT-BSW-040',
            'singkatan' => 'SP-Beasiswa',
            'deskripsi' => 'Surat pengantar untuk pengajuan beasiswa',
            'variabel' => [
                'nama_pemohon' => 'Nama siswa/mahasiswa',
                'nik' => 'NIK',
                'sekolah_kampus' => 'Nama sekolah/kampus',
                'jenjang' => 'Jenjang pendidikan',
                'alamat' => 'Alamat',
                'nama_ortu' => 'Nama orang tua',
                'pekerjaan_ortu' => 'Pekerjaan orang tua',
                'penghasilan_ortu' => 'Penghasilan orang tua',
            ],
            'format_nomor' => '{nomor}/SKT-BSW/{romawi}/{tahun}',
            'perlu_ttd_kades' => true,
            'aktif_permohonan_online' => true,
            'aktif' => true,
            'urutan' => 40,
        ];

        // 41. Surat Rekomendasi UMKM
        $jenisSurat[] = [
            'kategori_id' => $bnt,
            'nama' => 'Surat Rekomendasi UMKM',
            'kode' => 'SKT-UMK-041',
            'singkatan' => 'Rekomendasi UMKM',
            'deskripsi' => 'Surat rekomendasi untuk pelaku UMKM',
            'variabel' => [
                'nama_pemohon' => 'Nama pemilik',
                'nik' => 'NIK',
                'nama_usaha' => 'Nama usaha',
                'jenis_usaha' => 'Jenis usaha',
                'alamat_usaha' => 'Alamat usaha',
                'tahun_berdiri' => 'Tahun berdiri',
                'keperluan' => 'Keperluan',
            ],
            'format_nomor' => '{nomor}/SKT-UMK/{romawi}/{tahun}',
            'perlu_ttd_kades' => true,
            'aktif_permohonan_online' => true,
            'aktif' => true,
            'urutan' => 41,
        ];

        // 42. Surat Keterangan Layak Bantuan
        $jenisSurat[] = [
            'kategori_id' => $bnt,
            'nama' => 'Surat Keterangan Layak Bantuan',
            'kode' => 'SKT-LKB-042',
            'singkatan' => 'SK-Layak Bantuan',
            'deskripsi' => 'Surat keterangan kelayakan menerima bantuan',
            'variabel' => [
                'nama_pemohon' => 'Nama',
                'nik' => 'NIK',
                'alamat' => 'Alamat',
                'pekerjaan' => 'Pekerjaan',
                'penghasilan' => 'Penghasilan',
                'kondisi_rumah' => 'Kondisi rumah',
                'jumlah_tanggungan' => 'Jumlah tanggungan',
                'keperluan' => 'Keperluan',
            ],
            'format_nomor' => '{nomor}/SKT-LKB/{romawi}/{tahun}',
            'perlu_ttd_kades' => true,
            'aktif_permohonan_online' => true,
            'aktif' => true,
            'urutan' => 42,
        ];

        // KATEGORI 6: KHUSUS & LAINNYA (3 Surat)
        
        // 43. Surat Izin Keramaian
        $jenisSurat[] = [
            'kategori_id' => $khs,
            'nama' => 'Surat Izin Keramaian',
            'kode' => 'SKT-IKR-043',
            'singkatan' => 'Izin Keramaian',
            'deskripsi' => 'Surat izin untuk mengadakan keramaian/acara',
            'variabel' => [
                'nama_pemohon' => 'Nama pemohon',
                'nik' => 'NIK',
                'jenis_acara' => 'Jenis acara',
                'tanggal_acara' => 'Tanggal acara',
                'waktu_acara' => 'Waktu acara',
                'tempat_acara' => 'Tempat acara',
                'jumlah_peserta' => 'Perkiraan jumlah peserta',
            ],
            'format_nomor' => '{nomor}/SKT-IKR/{romawi}/{tahun}',
            'perlu_ttd_kades' => true,
            'aktif_permohonan_online' => true,
            'aktif' => true,
            'urutan' => 43,
        ];

        // 44. Surat Izin Mendirikan Bangunan (Pengantar)
        $jenisSurat[] = [
            'kategori_id' => $khs,
            'nama' => 'Surat Izin Mendirikan Bangunan (Pengantar)',
            'kode' => 'SKT-IMB-044',
            'singkatan' => 'SP-IMB',
            'deskripsi' => 'Surat pengantar untuk pengurusan IMB ke kecamatan',
            'variabel' => [
                'nama_pemohon' => 'Nama pemilik',
                'nik' => 'NIK',
                'lokasi_bangunan' => 'Lokasi bangunan',
                'jenis_bangunan' => 'Jenis bangunan',
                'luas_bangunan' => 'Luas bangunan',
                'luas_tanah' => 'Luas tanah',
            ],
            'format_nomor' => '{nomor}/SKT-IMB/{romawi}/{tahun}',
            'perlu_ttd_kades' => true,
            'aktif_permohonan_online' => true,
            'aktif' => true,
            'urutan' => 44,
        ];

        // 45. Surat Rekomendasi Kegiatan
        $jenisSurat[] = [
            'kategori_id' => $khs,
            'nama' => 'Surat Rekomendasi Kegiatan',
            'kode' => 'SKT-RKG-045',
            'singkatan' => 'Rekomendasi Kegiatan',
            'deskripsi' => 'Surat rekomendasi untuk kegiatan tertentu',
            'variabel' => [
                'nama_pemohon' => 'Nama pemohon',
                'organisasi' => 'Nama organisasi',
                'jenis_kegiatan' => 'Jenis kegiatan',
                'tanggal_kegiatan' => 'Tanggal kegiatan',
                'tempat_kegiatan' => 'Tempat kegiatan',
                'tujuan_kegiatan' => 'Tujuan kegiatan',
            ],
            'format_nomor' => '{nomor}/SKT-RKG/{romawi}/{tahun}',
            'perlu_ttd_kades' => true,
            'aktif_permohonan_online' => true,
            'aktif' => true,
            'urutan' => 45,
        ];

        // Insert all
        foreach ($jenisSurat as $surat) {
            SuratJenis::create($surat);
        }
        
        $this->command->newLine();
        $this->command->info('✅ 25 Jenis Surat Tambahan berhasil ditambahkan!');
        $this->command->info('📊 Total sekarang: 45 jenis surat');
    }
}
