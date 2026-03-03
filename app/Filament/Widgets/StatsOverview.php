<?php

namespace App\Filament\Widgets;

use App\Models\Penduduk;
use App\Models\Keluarga;
use App\Models\SuratArsip;
use App\Models\KeuanganTransaksi;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        $totalPenduduk = Penduduk::count();
        $lk = Penduduk::where('jenis_kelamin', 'L')->count();
        $pr = Penduduk::where('jenis_kelamin', 'P')->count();
        $totalKK = Keluarga::count();
        $suratBulanIni = SuratArsip::whereMonth('tanggal_surat', now()->month)
            ->whereYear('tanggal_surat', now()->year)->count();
        $totalPenerimaan = KeuanganTransaksi::where('jenis', 'penerimaan')
            ->where('status', 'terverifikasi')->sum('jumlah');
        $totalPengeluaran = KeuanganTransaksi::where('jenis', 'pengeluaran')
            ->where('status', 'terverifikasi')->sum('jumlah');

        return [
            Stat::make('Total Penduduk', number_format($totalPenduduk))
                ->description("L: {$lk} | P: {$pr}")
                ->descriptionIcon('heroicon-o-users')
                ->color('primary')
                ->chart([7, 3, 4, 5, 6, $totalPenduduk]),

            Stat::make('Jumlah KK', number_format($totalKK))
                ->description('Kartu Keluarga aktif')
                ->descriptionIcon('heroicon-o-home')
                ->color('success'),

            Stat::make('Surat Bulan Ini', number_format($suratBulanIni))
                ->description('Surat diterbitkan')
                ->descriptionIcon('heroicon-o-document-text')
                ->color('warning'),

            Stat::make('Saldo Kas', 'Rp ' . number_format($totalPenerimaan - $totalPengeluaran, 0, ',', '.'))
                ->description('Penerimaan - Pengeluaran')
                ->descriptionIcon('heroicon-o-banknotes')
                ->color($totalPenerimaan >= $totalPengeluaran ? 'success' : 'danger'),
        ];
    }
}
