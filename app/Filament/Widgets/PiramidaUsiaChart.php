<?php

namespace App\Filament\Widgets;

use App\Models\Penduduk;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

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
        return Cache::remember('piramida-usia', 3600, function() {
            $groups = [
                '0-4', '5-9', '10-14', '15-19', '20-24', '25-29', '30-34', '35-39',
                '40-44', '45-49', '50-54', '55-59', '60-64', '65-69', '70-74', '75+'
            ];

            // Single query dengan GROUP BY - 32 query jadi 1 query!
            $data = DB::table('penduduk')
                ->select(
                    'jenis_kelamin',
                    DB::raw('
                        CASE
                            WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 0 AND 4 THEN "0-4"
                            WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 5 AND 9 THEN "5-9"
                            WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 10 AND 14 THEN "10-14"
                            WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 15 AND 19 THEN "15-19"
                            WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 20 AND 24 THEN "20-24"
                            WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 25 AND 29 THEN "25-29"
                            WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 30 AND 34 THEN "30-34"
                            WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 35 AND 39 THEN "35-39"
                            WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 40 AND 44 THEN "40-44"
                            WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 45 AND 49 THEN "45-49"
                            WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 50 AND 54 THEN "50-54"
                            WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 55 AND 59 THEN "55-59"
                            WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 60 AND 64 THEN "60-64"
                            WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 65 AND 69 THEN "65-69"
                            WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 70 AND 74 THEN "70-74"
                            ELSE "75+"
                        END as kelompok_umur
                    '),
                    DB::raw('COUNT(*) as jumlah')
                )
                ->whereNotNull('tanggal_lahir')
                ->where('status', 'aktif')
                ->groupBy('jenis_kelamin', 'kelompok_umur')
                ->get();

            // Transform ke format chart
            $lakiLaki = [];
            $perempuan = [];

            foreach ($groups as $group) {
                $lk = $data->where('jenis_kelamin', 'L')->where('kelompok_umur', $group)->first();
                $pr = $data->where('jenis_kelamin', 'P')->where('kelompok_umur', $group)->first();

                $lakiLaki[] = -abs($lk ? $lk->jumlah : 0);
                $perempuan[] = abs($pr ? $pr->jumlah : 0);
            }

            return [
                'datasets' => [
                    [
                        'label' => 'Laki-laki',
                        'data' => $lakiLaki,
                        'backgroundColor' => '#3B82F6',
                        'borderWidth' => 0,
                        'borderRadius' => 4,
                        'barPercentage' => 0.9,
                        'categoryPercentage' => 0.9,
                    ],
                    [
                        'label' => 'Perempuan',
                        'data' => $perempuan,
                        'backgroundColor' => '#EC4899',
                        'borderWidth' => 0,
                        'borderRadius' => 4,
                        'barPercentage' => 0.9,
                        'categoryPercentage' => 0.9,
                    ],
                ],
                'labels' => $groups,
            ];
        });
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
