<?php

namespace App\Filament\Widgets;

use App\Models\Apbdes;
use App\Models\ApbdesBidang;
use App\Models\KeuanganTransaksi;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class DashboardKeuangan extends Widget
{
    protected static ?int $sort = 8;
    protected int | string | array $columnSpan = 'full';
    protected static string $view = 'filament.widgets.dashboard-keuangan';

    public function getData(): array
    {
        $tahunAktif = now()->year;
        
        return Cache::remember('dashboard-keuangan-' . $tahunAktif, 600, function() use ($tahunAktif) {
            $apbdes = Apbdes::where('tahun', $tahunAktif)->first();

            if (!$apbdes) {
                return [
                    'tahun' => $tahunAktif,
                    'total_anggaran' => 0,
                    'total_realisasi' => 0,
                    'persentase' => 0,
                    'sisa' => 0,
                    'bidang' => [],
                ];
            }

            // Hitung realisasi per bidang
            $bidangData = ApbdesBidang::where('apbdes_id', $apbdes->id)
                ->where('parent_id', null) // Hanya bidang utama
                ->get()
                ->map(function ($bidang) {
                    // Hitung total anggaran bidang (termasuk sub-bidang)
                    $totalAnggaran = $this->hitungTotalAnggaran($bidang->id);
                    
                    // Hitung realisasi dari transaksi
                    $realisasi = KeuanganTransaksi::where('bidang_id', $bidang->id)
                        ->where('status', 'terverifikasi')
                        ->sum('jumlah');

                    $persentase = $totalAnggaran > 0 ? ($realisasi / $totalAnggaran) * 100 : 0;

                    return [
                        'nama' => $bidang->nama,
                        'kode' => $bidang->kode,
                        'anggaran' => $totalAnggaran,
                        'realisasi' => $realisasi,
                        'persentase' => round($persentase, 2),
                        'sisa' => $totalAnggaran - $realisasi,
                    ];
                });

            $totalAnggaran = $bidangData->sum('anggaran');
            $totalRealisasi = $bidangData->sum('realisasi');
            $persentaseTotal = $totalAnggaran > 0 ? ($totalRealisasi / $totalAnggaran) * 100 : 0;

            return [
                'tahun' => $tahunAktif,
                'total_anggaran' => $totalAnggaran,
                'total_realisasi' => $totalRealisasi,
                'persentase' => round($persentaseTotal, 2),
                'sisa' => $totalAnggaran - $totalRealisasi,
                'bidang' => $bidangData->toArray(),
            ];
        });
    }

    protected function hitungTotalAnggaran($bidangId): float
    {
        $bidang = ApbdesBidang::find($bidangId);
        $total = $bidang->pagu ?? 0;

        // Tambahkan anggaran dari sub-bidang
        $subBidang = ApbdesBidang::where('parent_id', $bidangId)->get();
        foreach ($subBidang as $sub) {
            $total += $this->hitungTotalAnggaran($sub->id);
        }

        return $total;
    }
}
