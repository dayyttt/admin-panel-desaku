<?php

namespace Database\Seeders;

use App\Models\Apbdes;
use App\Models\KeuanganTransaksi;
use App\Models\KeuanganBukuKas;
use Illuminate\Database\Seeder;

class BukuKasSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil APBDes aktif
        $apbdes = Apbdes::where('tahun', date('Y'))->first();
        
        if (!$apbdes) {
            $this->command->warn('⚠️  APBDes tahun ' . date('Y') . ' tidak ditemukan. Jalankan ApbdesSeeder terlebih dahulu.');
            return;
        }

        // Ambil semua transaksi yang sudah terverifikasi, urutkan berdasarkan tanggal
        $transaksi = KeuanganTransaksi::where('apbdes_id', $apbdes->id)
            ->where('status', 'terverifikasi')
            ->orderBy('tanggal', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        if ($transaksi->isEmpty()) {
            $this->command->warn('⚠️  Tidak ada transaksi terverifikasi. Jalankan KeuanganTransaksiSeeder terlebih dahulu.');
            return;
        }

        $bukuKas = [];
        $saldo = 0; // Saldo awal

        foreach ($transaksi as $t) {
            $debit = 0;
            $kredit = 0;

            // Hitung debit/kredit berdasarkan jenis transaksi
            if ($t->jenis === 'penerimaan') {
                $debit = $t->jumlah;
                $saldo += $debit;
            } else {
                $kredit = $t->jumlah;
                $saldo -= $kredit;
            }

            $bukuKas[] = [
                'apbdes_id' => $apbdes->id,
                'transaksi_id' => $t->id,
                'tanggal' => $t->tanggal,
                'uraian' => $t->uraian,
                'debit' => $debit,
                'kredit' => $kredit,
                'saldo' => $saldo,
                'created_at' => $t->created_at,
                'updated_at' => $t->updated_at,
            ];
        }

        KeuanganBukuKas::insert($bukuKas);
        
        $this->command->info('✅ Berhasil membuat ' . count($bukuKas) . ' entri buku kas umum');
        $this->command->info('💰 Saldo akhir: Rp ' . number_format($saldo, 0, ',', '.'));
    }
}
