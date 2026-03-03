<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use App\Services\LaporanKependudukanService;

class LaporanStatistik extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';
    protected static ?string $navigationLabel = 'Laporan & Statistik';
    protected static ?string $navigationGroup = 'Kependudukan';
    protected static ?int $navigationSort = 10;
    protected static string $view = 'filament.pages.laporan-statistik';
    protected static ?string $title = 'Laporan & Statistik Kependudukan';

    public $bulan;
    public $tahun;

    public function mount(): void
    {
        $this->bulan = now()->month;
        $this->tahun = now()->year;
    }

    public function downloadLaporanBulanan()
    {
        try {
            $service = new LaporanKependudukanService();
            $pdf = $service->laporanBulanan($this->bulan, $this->tahun);
            
            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->output();
            }, "Laporan_Kependudukan_{$this->bulan}_{$this->tahun}.pdf");
        } catch (\Exception $e) {
            Notification::make()
                ->title('Gagal membuat laporan')
                ->danger()
                ->body($e->getMessage())
                ->send();
        }
    }

    public function downloadKelompokRentan()
    {
        try {
            $service = new LaporanKependudukanService();
            $pdf = $service->laporanKelompokRentan();
            
            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->output();
            }, 'Laporan_Kelompok_Rentan_' . now()->format('Y') . '.pdf');
        } catch (\Exception $e) {
            Notification::make()
                ->title('Gagal membuat laporan')
                ->danger()
                ->body($e->getMessage())
                ->send();
        }
    }
}
