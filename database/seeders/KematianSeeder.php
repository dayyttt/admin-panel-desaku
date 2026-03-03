<?php

namespace Database\Seeders;

use App\Models\Kematian;
use App\Models\Penduduk;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class KematianSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil penduduk lansia untuk data kematian
        $pendudukLansia = Penduduk::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) >= 60')
            ->limit(2)
            ->get();

        // Jika tidak ada lansia, ambil penduduk random
        if ($pendudukLansia->isEmpty()) {
            $pendudukLansia = Penduduk::limit(2)->get();
        }

        $kematian = [];
        $counter = 1;

        foreach ($pendudukLansia as $penduduk) {
            $tanggalKematian = Carbon::now()->subMonths(rand(1, 12));
            
            $kematian[] = [
                'penduduk_id' => $penduduk->id,
                'nik' => $penduduk->nik,
                'nama' => $penduduk->nama,
                'tanggal_kematian' => $tanggalKematian->format('Y-m-d'),
                'jam_kematian' => sprintf('%02d:%02d:00', rand(0, 23), rand(0, 59)),
                'tempat_kematian' => ['Rumah', 'RSUD Masohi', 'Puskesmas Lesane'][rand(0, 2)],
                'penyebab_kematian' => ['Sakit tua', 'Penyakit jantung', 'Stroke', 'Diabetes'][rand(0, 3)],
                'jenis_kematian' => 'wajar',
                'nama_pelapor' => 'Keluarga ' . $penduduk->nama,
                'nik_pelapor' => null,
                'hubungan_pelapor' => ['Anak', 'Cucu', 'Saudara'][rand(0, 2)],
                'no_akta_kematian' => '5302-AK-' . date('d') . date('m') . date('Y') . '-' . str_pad($counter, 4, '0', STR_PAD_LEFT),
                'tanggal_akta' => $tanggalKematian->addDays(rand(3, 14))->format('Y-m-d'),
                'diinput_oleh' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $counter++;
        }

        Kematian::insert($kematian);
        
        $this->command->info('✅ Berhasil membuat ' . count($kematian) . ' data kematian');
    }
}
