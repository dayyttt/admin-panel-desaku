<?php

namespace App\Filament\Widgets;

use App\Models\Penduduk;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class UmurChart extends ChartWidget
{
    protected static ?string $heading = 'Kelompok Umur';
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 1;
    protected static ?string $maxHeight = '280px';

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        $now = Carbon::now();
        $groups = [
            '0-5' => [0, 5],
            '6-17' => [6, 17],
            '18-25' => [18, 25],
            '26-35' => [26, 35],
            '36-45' => [36, 45],
            '46-55' => [46, 55],
            '56-65' => [56, 65],
            '65+' => [65, 200],
        ];

        $data = [];
        foreach ($groups as $label => [$min, $max]) {
            $data[] = Penduduk::whereNotNull('tanggal_lahir')
                ->whereDate('tanggal_lahir', '<=', $now->copy()->subYears($min))
                ->whereDate('tanggal_lahir', '>', $now->copy()->subYears($max + 1))
                ->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah',
                    'data' => $data,
                    'backgroundColor' => [
                        '#A78BFA', '#818CF8', '#6366F1', '#4F46E5',
                        '#4338CA', '#3730A3', '#312E81', '#1E1B4B',
                    ],
                    'borderRadius' => 6,
                ],
            ],
            'labels' => array_keys($groups),
        ];
    }
}
