<?php

namespace App\Filament\Widgets;

use App\Models\Penduduk;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class PiramidaUsiaChart extends ChartWidget
{
    protected static ?string $heading = 'Piramida Penduduk';
    protected static ?int $sort = 7;
    protected int | string | array $columnSpan = 'full';
    protected static ?string $maxHeight = '400px';

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        $now = Carbon::now();
        
        // Kelompok umur 5 tahunan untuk piramida
        $groups = [
            '0-4', '5-9', '10-14', '15-19', '20-24', '25-29', '30-34', '35-39',
            '40-44', '45-49', '50-54', '55-59', '60-64', '65-69', '70-74', '75+'
        ];

        $lakiLaki = [];
        $perempuan = [];

        foreach ($groups as $group) {
            if ($group === '75+') {
                $min = 75;
                $max = 150;
            } else {
                [$min, $max] = explode('-', $group);
                $max = (int)$max;
                $min = (int)$min;
            }

            // Hitung laki-laki (negatif untuk tampilan piramida)
            $lk = Penduduk::where('jenis_kelamin', 'L')
                ->whereNotNull('tanggal_lahir')
                ->whereDate('tanggal_lahir', '<=', $now->copy()->subYears($min))
                ->whereDate('tanggal_lahir', '>', $now->copy()->subYears($max + 1))
                ->count();
            
            // Hitung perempuan (positif)
            $pr = Penduduk::where('jenis_kelamin', 'P')
                ->whereNotNull('tanggal_lahir')
                ->whereDate('tanggal_lahir', '<=', $now->copy()->subYears($min))
                ->whereDate('tanggal_lahir', '>', $now->copy()->subYears($max + 1))
                ->count();

            $lakiLaki[] = -$lk; // Negatif untuk tampilan ke kiri
            $perempuan[] = $pr;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Laki-laki',
                    'data' => $lakiLaki,
                    'backgroundColor' => '#3B82F6',
                    'borderRadius' => 4,
                ],
                [
                    'label' => 'Perempuan',
                    'data' => $perempuan,
                    'backgroundColor' => '#EC4899',
                    'borderRadius' => 4,
                ],
            ],
            'labels' => $groups,
        ];
    }

    protected function getOptions(): array
    {
        return [
            'indexAxis' => 'y',
            'scales' => [
                'x' => [
                    'stacked' => false,
                    'ticks' => [
                        'callback' => 'function(value) { return Math.abs(value); }',
                    ],
                ],
                'y' => [
                    'stacked' => false,
                ],
            ],
            'plugins' => [
                'tooltip' => [
                    'callbacks' => [
                        'label' => 'function(context) { return context.dataset.label + ": " + Math.abs(context.parsed.x) + " jiwa"; }',
                    ],
                ],
                'legend' => [
                    'display' => true,
                    'position' => 'top',
                ],
            ],
        ];
    }
}
