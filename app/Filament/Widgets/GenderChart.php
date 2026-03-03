<?php

namespace App\Filament\Widgets;

use App\Models\Penduduk;
use Filament\Widgets\ChartWidget;

class GenderChart extends ChartWidget
{
    protected static ?string $heading = 'Jenis Kelamin';
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 1;
    protected static ?string $maxHeight = '280px';

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getData(): array
    {
        $lk = Penduduk::where('jenis_kelamin', 'L')->count();
        $pr = Penduduk::where('jenis_kelamin', 'P')->count();

        return [
            'datasets' => [
                [
                    'data' => [$lk, $pr],
                    'backgroundColor' => ['#3B82F6', '#EC4899'],
                ],
            ],
            'labels' => ['Laki-laki', 'Perempuan'],
        ];
    }
}
