<?php

namespace Database\Seeders;

use App\Models\SuratMasuk;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SuratMasukSeeder extends Seeder
{
    public function run(): void
    {
        $suratMasuk = [];

        // Data surat masuk dari berbagai instansi
        $dataSurat = [
            [
                'asal' => 'Kecamatan Teluti',
                'perihal' => 'Undangan Rapat Koordinasi Kecamatan',
                'klasifikasi' => 'Undangan',
                'sifat' => 'segera',
                'ringkasan' => 'Undangan menghadiri rapat koordinasi tingkat kecamatan membahas program pembangunan desa tahun 2026',
                'disposisi' => 'Kepala Desa untuk hadir',
            ],
            [
                'asal' => 'Dinas Kependudukan dan Pencatatan Sipil Kabupaten Maluku Tengah',
                'perihal' => 'Pemutakhiran Data Kependudukan',
                'klasifikasi' => 'Surat Dinas',
                'sifat' => 'biasa',
                'ringkasan' => 'Permintaan pemutakhiran data kependudukan semester I tahun 2026 untuk dilaporkan paling lambat akhir bulan',
                'disposisi' => 'Kaur Pemerintahan untuk ditindaklanjuti',
            ],
            [
                'asal' => 'Dinas Sosial Kabupaten Maluku Tengah',
                'perihal' => 'Verifikasi Data Penerima Bantuan Sosial',
                'klasifikasi' => 'Surat Dinas',
                'sifat' => 'segera',
                'ringkasan' => 'Permintaan verifikasi dan validasi data penerima bantuan sosial PKH dan BPNT untuk periode Januari-Juni 2026',
                'disposisi' => 'Kaur Kesejahteraan untuk verifikasi data',
            ],
            [
                'asal' => 'Badan Perencanaan Pembangunan Daerah (Bappeda)',
                'perihal' => 'Usulan Program Pembangunan Desa 2027',
                'klasifikasi' => 'Surat Dinas',
                'sifat' => 'biasa',
                'ringkasan' => 'Permintaan usulan program pembangunan desa untuk dimasukkan dalam RKPD tahun 2027',
                'disposisi' => 'Kaur Perencanaan untuk menyusun usulan',
            ],
            [
                'asal' => 'Dinas Kesehatan Kabupaten Maluku Tengah',
                'perihal' => 'Pelaksanaan Posyandu dan Imunisasi',
                'klasifikasi' => 'Surat Dinas',
                'sifat' => 'biasa',
                'ringkasan' => 'Jadwal pelaksanaan posyandu dan imunisasi balita bulan Maret 2026 di Desa Lesane',
                'disposisi' => 'Kader Posyandu untuk koordinasi',
            ],
            [
                'asal' => 'Camat Teluti',
                'perihal' => 'Laporan Realisasi APBDes Triwulan I',
                'klasifikasi' => 'Surat Dinas',
                'sifat' => 'sangat_segera',
                'ringkasan' => 'Permintaan laporan realisasi APBDes triwulan I tahun 2026 untuk dilaporkan paling lambat 5 hari kerja',
                'disposisi' => 'Kaur Keuangan untuk segera menyusun laporan',
            ],
            [
                'asal' => 'BPD (Badan Permusyawaratan Desa) Lesane',
                'perihal' => 'Usulan Musyawarah Desa',
                'klasifikasi' => 'Surat Internal',
                'sifat' => 'biasa',
                'ringkasan' => 'Usulan penyelenggaraan musyawarah desa untuk membahas perubahan APBDes tahun 2026',
                'disposisi' => 'Sekretaris Desa untuk persiapan',
            ],
            [
                'asal' => 'Dinas Pendidikan Kabupaten Maluku Tengah',
                'perihal' => 'Data Anak Usia Sekolah',
                'klasifikasi' => 'Surat Dinas',
                'sifat' => 'biasa',
                'ringkasan' => 'Permintaan data anak usia sekolah (7-18 tahun) untuk perencanaan penerimaan siswa baru tahun ajaran 2026/2027',
                'disposisi' => 'Kaur Pemerintahan untuk menyiapkan data',
            ],
            [
                'asal' => 'Polsek Teluti',
                'perihal' => 'Himbauan Keamanan dan Ketertiban',
                'klasifikasi' => 'Surat Dinas',
                'sifat' => 'biasa',
                'ringkasan' => 'Himbauan untuk meningkatkan keamanan dan ketertiban desa menjelang hari raya',
                'disposisi' => 'Kepala Desa dan Kadus untuk sosialisasi',
            ],
            [
                'asal' => 'Dinas Pertanian Kabupaten Maluku Tengah',
                'perihal' => 'Program Bantuan Bibit Tanaman',
                'klasifikasi' => 'Surat Dinas',
                'sifat' => 'biasa',
                'ringkasan' => 'Informasi program bantuan bibit tanaman hortikultura dan usulan kelompok tani penerima bantuan',
                'disposisi' => 'Kaur Ekonomi untuk koordinasi dengan kelompok tani',
            ],
        ];

        $counter = 1;
        foreach ($dataSurat as $data) {
            // Tanggal surat 1-30 hari yang lalu
            $tanggalSurat = Carbon::now()->subDays(rand(1, 30));
            // Tanggal diterima 0-3 hari setelah tanggal surat
            $tanggalDiterima = (clone $tanggalSurat)->addDays(rand(0, 3));

            $suratMasuk[] = [
                'nomor_surat' => $this->generateNomorSurat($data['asal'], $counter, $tanggalSurat),
                'tanggal_surat' => $tanggalSurat->format('Y-m-d'),
                'tanggal_diterima' => $tanggalDiterima->format('Y-m-d'),
                'asal_pengirim' => $data['asal'],
                'perihal' => $data['perihal'],
                'ringkasan' => $data['ringkasan'],
                'file_path' => null,
                'klasifikasi' => $data['klasifikasi'],
                'sifat' => $data['sifat'],
                'disposisi' => $data['disposisi'],
                'diterima_oleh' => 1, // User ID admin
                'created_at' => $tanggalDiterima,
                'updated_at' => $tanggalDiterima,
            ];

            $counter++;
        }

        SuratMasuk::insert($suratMasuk);
        
        $this->command->info('✅ Berhasil membuat ' . count($suratMasuk) . ' data surat masuk');
    }

    private function generateNomorSurat($asal, $counter, $tanggal): string
    {
        $tahun = $tanggal->format('Y');
        $bulan = $tanggal->format('m');
        
        // Generate kode berdasarkan asal surat
        $kode = 'UM'; // Umum
        if (str_contains($asal, 'Kecamatan')) {
            $kode = 'KEC';
        } elseif (str_contains($asal, 'Dinas')) {
            $kode = 'DNS';
        } elseif (str_contains($asal, 'Bappeda') || str_contains($asal, 'Badan')) {
            $kode = 'BDN';
        } elseif (str_contains($asal, 'BPD')) {
            $kode = 'BPD';
        } elseif (str_contains($asal, 'Polsek') || str_contains($asal, 'Polres')) {
            $kode = 'POL';
        }
        
        // Format: 005/KEC/III/2026
        return sprintf(
            '%03d/%s/%s/%s',
            $counter,
            $kode,
            $this->getRomanMonth($bulan),
            $tahun
        );
    }

    private function getRomanMonth($month): string
    {
        $romans = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        return $romans[(int)$month - 1];
    }
}
