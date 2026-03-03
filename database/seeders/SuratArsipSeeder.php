<?php

namespace Database\Seeders;

use App\Models\SuratArsip;
use App\Models\SuratJenis;
use App\Models\Penduduk;
use App\Models\DokumenTtd;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Str;

class SuratArsipSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil jenis surat yang aktif
        $jenisSurat = SuratJenis::where('aktif', true)->limit(5)->get();
        
        if ($jenisSurat->isEmpty()) {
            $this->command->warn('⚠️  Tidak ada jenis surat. Jalankan SuratJenisSeeder terlebih dahulu.');
            return;
        }

        // Ambil penduduk untuk pemohon
        $penduduk = Penduduk::limit(10)->get();
        
        if ($penduduk->isEmpty()) {
            $this->command->warn('⚠️  Tidak ada data penduduk. Jalankan PendudukSeeder terlebih dahulu.');
            return;
        }

        // Ambil TTD default
        $ttd = DokumenTtd::where('default', true)->first();

        $arsip = [];
        $nomorCounter = 1;

        // Buat 10 arsip surat
        foreach ($jenisSurat as $jenis) {
            for ($i = 0; $i < 2; $i++) {
                $pemohon = $penduduk->random();
                $tanggalSurat = Carbon::now()->subDays(rand(1, 90));
                
                $arsip[] = [
                    'surat_jenis_id' => $jenis->id,
                    'penduduk_id' => $pemohon->id,
                    'nik_pemohon' => $pemohon->nik,
                    'nama_pemohon' => $pemohon->nama,
                    'nomor_surat' => $this->generateNomorSurat($jenis, $nomorCounter, $tanggalSurat),
                    'tanggal_surat' => $tanggalSurat->format('Y-m-d'),
                    'keperluan' => $this->getKeperluan($jenis->kode),
                    'data_surat' => json_encode([
                        'nik' => $pemohon->nik,
                        'nama' => $pemohon->nama,
                        'tempat_lahir' => $pemohon->tempat_lahir,
                        'tanggal_lahir' => $pemohon->tanggal_lahir,
                        'jenis_kelamin' => $pemohon->jenis_kelamin,
                        'alamat' => $pemohon->alamat,
                        'rt' => $pemohon->rt,
                        'rw' => $pemohon->rw,
                        'agama' => $pemohon->agama,
                        'pekerjaan' => $pemohon->pekerjaan,
                        'status_kawin' => $pemohon->status_kawin,
                    ]),
                    'file_pdf_path' => null,
                    'qr_code' => Str::random(32),
                    'ttd_id' => $ttd ? $ttd->id : null,
                    'dibuat_oleh' => 1,
                    'permohonan_id' => null,
                    'created_at' => $tanggalSurat,
                    'updated_at' => $tanggalSurat,
                ];
                
                $nomorCounter++;
            }
        }

        SuratArsip::insert($arsip);
        
        $this->command->info('✅ Berhasil membuat ' . count($arsip) . ' arsip surat');
    }

    private function generateNomorSurat($jenis, $counter, $tanggal): string
    {
        $tahun = $tanggal->format('Y');
        $bulan = $tanggal->format('m');
        
        // Format: 474.3/001/KODE/BULAN/TAHUN
        return sprintf(
            '474.3/%03d/%s/%s/%s',
            $counter,
            strtoupper($jenis->kode),
            $this->getRomanMonth($bulan),
            $tahun
        );
    }

    private function getRomanMonth($month): string
    {
        $romans = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        return $romans[(int)$month - 1];
    }

    private function getKeperluan($kode): string
    {
        $keperluan = [
            'sktm' => 'Mengurus beasiswa pendidikan',
            'skd' => 'Persyaratan melamar pekerjaan',
            'sku' => 'Mengurus izin usaha',
            'skck' => 'Persyaratan melamar pekerjaan',
            'sppb' => 'Mengurus akta kelahiran',
            'skp' => 'Pindah ke Kota Ambon',
            'sket_nikah' => 'Persyaratan menikah',
            'sket_belum_nikah' => 'Persyaratan menikah',
            'sket_tidak_mampu' => 'Berobat di rumah sakit',
            'sket_usaha' => 'Mengurus izin usaha',
        ];

        return $keperluan[$kode] ?? 'Keperluan administrasi';
    }
}
