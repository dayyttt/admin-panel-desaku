<?php

namespace App\Filament\Widgets;

use App\Models\Penduduk;
use Filament\Widgets\ChartWidget;

class AgamaChart extends ChartWidget
{
    protected static ?string $heading = 'Agama Penduduk';
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 1;
    protected static ?string $maxHeight = '280px';

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getData(): array
    {
        $agamaList = ['islam', 'kristen', 'katolik', 'hindu', 'buddha', 'konghucu'];
        $colors = ['#10B981', '#3B82F6', '#8B5CF6', '#F59E0B', '#EF4444', '#EC4899'];
        $labels = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'];

        $data = [];
        foreach ($agamaList as $agama) {
            $count = Penduduk::where('agama', $agama)->count();
            $data[] = $count;
        }

        // Filter out zeros
        $filtered = [];
        $filteredLabels = [];
        $filteredColors = [];
        foreach ($data as $i => $d) {
            if ($d > 0) {
                $filtered[] = $d;
                $filteredLabels[] = $labels[$i];
                $filteredColors[] = $colors[$i];
            }
        }

        return [
            'datasets' => [
                ['data' => $filtered ?: [0], 'backgroundColor' => $filteredColors ?: ['#ccc']],
            ],
            'labels' => $filteredLabels ?: ['Belum ada data'],
        ];
    }
}
