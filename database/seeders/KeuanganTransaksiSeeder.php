<?php

namespace Database\Seeders;

use App\Models\Apbdes;
use App\Models\ApbdesBidang;
use App\Models\KeuanganTransaksi;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class KeuanganTransaksiSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil APBDes aktif
        $apbdes = Apbdes::where('tahun', date('Y'))->first();
        
        if (!$apbdes) {
            $this->command->warn('⚠️  APBDes tahun ' . date('Y') . ' tidak ditemukan. Jalankan ApbdesSeeder terlebih dahulu.');
            return;
        }

        // Ambil kegiatan level untuk transaksi
        $kegiatan = ApbdesBidang::where('apbdes_id', $apbdes->id)
            ->where('level', 'kegiatan')
            ->get();

        $transaksi = [];
        $noBukti = 1;

        // Buat transaksi penerimaan (pendapatan)
        $kegiatanPendapatan = $kegiatan->where('jenis', 'pendapatan')->take(3);
        foreach ($kegiatanPendapatan as $k) {
            $tanggal = Carbon::create(date('Y'), rand(1, 3), rand(1, 28));
            
            $transaksi[] = [
                'apbdes_id' => $apbdes->id,
                'bidang_id' => $k->id,
                'no_bukti' => 'BKM-' . str_pad($noBukti, 5, '0', STR_PAD_LEFT),
                'tanggal' => $tanggal->format('Y-m-d'),
                'jenis' => 'penerimaan',
                'uraian' => 'Penerimaan ' . $k->nama,
                'jumlah' => $k->anggaran * 0.3, // 30% dari anggaran
                'sumber_dana' => ['Dana Desa', 'ADD', 'PAD'][rand(0, 2)],
                'penerima_pembayar' => 'Pemerintah Kabupaten Maluku Tengah',
                'rekening_tujuan' => 'Bank Maluku - 1234567890',
                'bukti_path' => null,
                'status' => 'terverifikasi',
                'catatan' => 'Pencairan tahap 1',
                'alasan_tolak' => null,
                'diinput_oleh' => 1,
                'diverifikasi_oleh' => 1,
                'diverifikasi_at' => $tanggal->addDays(1),
                'created_at' => now(),
                'updated_at' => now(),
            ];
            
            $noBukti++;
        }

        // Buat transaksi pengeluaran (belanja)
        $kegiatanBelanja = $kegiatan->where('jenis', 'belanja')->take(5);
        foreach ($kegiatanBelanja as $k) {
            $tanggal = Carbon::create(date('Y'), rand(1, 3), rand(1, 28));
            
            $transaksi[] = [
                'apbdes_id' => $apbdes->id,
                'bidang_id' => $k->id,
                'no_bukti' => 'BKK-' . str_pad($noBukti, 5, '0', STR_PAD_LEFT),
                'tanggal' => $tanggal->format('Y-m-d'),
                'jenis' => 'pengeluaran',
                'uraian' => 'Pembayaran ' . $k->nama,
                'jumlah' => $k->anggaran * 0.25, // 25% dari anggaran
                'sumber_dana' => ['Dana Desa', 'ADD'][rand(0, 1)],
                'penerima_pembayar' => ['CV Maju Jaya', 'Toko Bangunan Sejahtera', 'PT Karya Mandiri', 'Bendahara Desa'][rand(0, 3)],
                'rekening_tujuan' => 'Bank Maluku - ' . rand(1000000000, 9999999999),
                'bukti_path' => null,
                'status' => ['terverifikasi', 'menunggu_verifikasi'][rand(0, 1)],
                'catatan' => 'Pembayaran sesuai RAB',
                'alasan_tolak' => null,
                'diinput_oleh' => 1,
                'diverifikasi_oleh' => rand(0, 1) ? 1 : null,
                'diverifikasi_at' => rand(0, 1) ? $tanggal->addDays(2) : null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            
            $noBukti++;
        }

        KeuanganTransaksi::insert($transaksi);
        
        $this->command->info('✅ Berhasil membuat ' . count($transaksi) . ' transaksi keuangan');
    }
}
