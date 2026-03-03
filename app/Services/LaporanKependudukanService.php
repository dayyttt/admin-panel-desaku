<?php

namespace App\Services;

use App\Models\Penduduk;
use App\Models\Keluarga;
use App\Models\Kelahiran;
use App\Models\Kematian;
use App\Models\PendudukPindah;
use App\Models\DesaConfig;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;

class LaporanKependudukanService
{
    public function laporanBulanan(int $bulan, int $tahun)
    {
        $desa = DesaConfig::first();
        $periode = Carbon::create($tahun, $bulan, 1);
        
        // Data statistik bulan ini
        $data = [
            'desa' => $desa,
            'periode' => $periode,
            'bulan_nama' => $periode->translatedFormat('F'),
            'tahun' => $tahun,
            
            // Total penduduk
            'total_penduduk' => Penduduk::where('status', 'aktif')->count(),
            'laki_laki' => Penduduk::where('status', 'aktif')->where('jenis_kelamin', 'L')->count(),
            'perempuan' => Penduduk::where('status', 'aktif')->where('jenis_kelamin', 'P')->count(),
            'total_kk' => Keluarga::where('status', 'aktif')->count(),
            
            // Mutasi bulan ini
            'kelahiran' => Kelahiran::whereMonth('tanggal_lahir', $bulan)
                ->whereYear('tanggal_lahir', $tahun)->count(),
            'kematian' => Kematian::whereMonth('tanggal_kematian', $bulan)
                ->whereYear('tanggal_kematian', $tahun)->count(),
            'pindah_keluar' => PendudukPindah::where('jenis', 'pindah_keluar')
                ->whereMonth('tanggal_pindah', $bulan)
                ->whereYear('tanggal_pindah', $tahun)->count(),
            'pindah_masuk' => PendudukPindah::where('jenis', 'datang')
                ->whereMonth('tanggal_pindah', $bulan)
                ->whereYear('tanggal_pindah', $tahun)->count(),
            
            // Distribusi
            'agama' => Penduduk::where('status', 'aktif')
                ->selectRaw('agama, COUNT(*) as jumlah')
                ->groupBy('agama')
                ->orderByDesc('jumlah')
                ->get(),
            
            'pendidikan' => Penduduk::where('status', 'aktif')
                ->whereNotNull('pendidikan_dalam_kk')
                ->selectRaw('pendidikan_dalam_kk, COUNT(*) as jumlah')
                ->groupBy('pendidikan_dalam_kk')
                ->orderByDesc('jumlah')
                ->get(),
            
            'pekerjaan' => Penduduk::where('status', 'aktif')
                ->whereNotNull('pekerjaan')
                ->where('pekerjaan', '!=', '')
                ->selectRaw('pekerjaan, COUNT(*) as jumlah')
                ->groupBy('pekerjaan')
                ->orderByDesc('jumlah')
                ->limit(10)
                ->get(),
            
            // Kelompok rentan
            'lansia' => Penduduk::where('status', 'aktif')
                ->whereNotNull('tanggal_lahir')
                ->whereDate('tanggal_lahir', '<=', now()->subYears(60))
                ->count(),
            'balita' => Penduduk::where('status', 'aktif')
                ->whereNotNull('tanggal_lahir')
                ->whereDate('tanggal_lahir', '>', now()->subYears(5))
                ->count(),
            'disabilitas' => Penduduk::where('status', 'aktif')
                ->where('cacat', true)
                ->count(),
            
            'tanggal_cetak' => now(),
        ];
        
        $pdf = Pdf::loadView('laporan.kependudukan-bulanan', $data);
        $pdf->setPaper('a4', 'portrait');
        
        return $pdf;
    }
    
    public function laporanKelompokRentan()
    {
        $desa = DesaConfig::first();
        
        $data = [
            'desa' => $desa,
            'tanggal_cetak' => now(),
            
            // Lansia
            'lansia' => Penduduk::where('status', 'aktif')
                ->whereNotNull('tanggal_lahir')
                ->whereDate('tanggal_lahir', '<=', now()->subYears(60))
                ->orderBy('tanggal_lahir')
                ->get(),
            
            // Balita
            'balita' => Penduduk::where('status', 'aktif')
                ->whereNotNull('tanggal_lahir')
                ->whereDate('tanggal_lahir', '>', now()->subYears(5))
                ->orderByDesc('tanggal_lahir')
                ->get(),
            
            // Disabilitas
            'disabilitas' => Penduduk::where('status', 'aktif')
                ->where('cacat', true)
                ->orderBy('nama')
                ->get(),
        ];
        
        $pdf = Pdf::loadView('laporan.kelompok-rentan', $data);
        $pdf->setPaper('a4', 'landscape');
        
        return $pdf;
    }
}
