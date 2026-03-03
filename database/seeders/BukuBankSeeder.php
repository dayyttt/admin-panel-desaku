<?php

namespace Database\Seeders;

use App\Models\Apbdes;
use App\Models\KeuanganTransaksi;
use App\Models\BukuBank;
use Illuminate\Database\Seeder;

class BukuBankSeeder extends Seeder
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

        // Data rekening bank desa
        $rekeningBank = [
            [
                'nama_bank' => 'Bank Maluku',
                'nomor_rekening' => '1234567890',
                'atas_nama' => 'Kas Desa Lesane',
            ],
            [
                'nama_bank' => 'BRI Unit Masohi',
                'nomor_rekening' => '0987654321',
                'atas_nama' => 'APBDes Desa Lesane',
            ],
        ];

        $bukuBank = [];
        $saldoPerBank = []; // Track saldo per rekening

        // Inisialisasi saldo awal untuk setiap bank
        foreach ($rekeningBank as $index => $bank) {
            $saldoPerBank[$index] = 0;
        }

        foreach ($transaksi as $t) {
            // Tentukan bank berdasarkan rekening tujuan atau random
            $bankIndex = 0; // Default ke bank pertama
            if ($t->rekening_tujuan && str_contains($t->rekening_tujuan, '0987654321')) {
                $bankIndex = 1;
            }

            $bank = $rekeningBank[$bankIndex];
            $debit = 0;
            $kredit = 0;

            // Hitung debit/kredit berdasarkan jenis transaksi
            if ($t->jenis === 'penerimaan') {
                $debit = $t->jumlah;
                $saldoPerBank[$bankIndex] += $debit;
            } else {
                $kredit = $t->jumlah;
                $saldoPerBank[$bankIndex] -= $kredit;
            }

            $bukuBank[] = [
                'apbdes_id' => $apbdes->id,
                'nama_bank' => $bank['nama_bank'],
                'nomor_rekening' => $bank['nomor_rekening'],
                'atas_nama' => $bank['atas_nama'],
                'tanggal' => $t->tanggal,
                'uraian' => $t->uraian,
                'debit' => $debit,
                'kredit' => $kredit,
                'saldo' => $saldoPerBank[$bankIndex],
                'transaksi_id' => $t->id,
                'sudah_rekonsiliasi' => rand(0, 1) ? true : false, // Random rekonsiliasi
                'created_at' => $t->created_at,
                'updated_at' => $t->updated_at,
            ];
        }

        BukuBank::insert($bukuBank);
        
        $this->command->info('✅ Berhasil membuat ' . count($bukuBank) . ' entri buku bank');
        foreach ($rekeningBank as $index => $bank) {
            $this->command->info('💳 ' . $bank['nama_bank'] . ' (' . $bank['nomor_rekening'] . '): Rp ' . number_format($saldoPerBank[$index], 0, ',', '.'));
        }
    }
}
