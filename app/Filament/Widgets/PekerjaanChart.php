<?php

namespace App\Filament\Widgets;

use App\Models\Penduduk;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class PekerjaanChart extends ChartWidget
{
    protected static ?string $heading = 'Pekerjaan Penduduk';
    protected static ?int $sort = 5;
    protected int | string | array $columnSpan = 1;
    protected static ?string $maxHeight = '280px';

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        $pekerjaan = Penduduk::select('pekerjaan', DB::raw('count(*) as total'))
            ->whereNotNull('pekerjaan')
            ->where('pekerjaan', '!=', '')
            ->groupBy('pekerjaan')
            ->orderByDesc('total')
            ->limit(8)
            ->get();

        $labels = $pekerjaan->pluck('pekerjaan')->map(fn ($p) => ucwords(str_replace('_', ' ', $p)))->toArray();
        $data = $pekerjaan->pluck('total')->toArray();

        $colors = ['#10B981', '#3B82F6', '#F59E0B', '#EF4444', '#8B5CF6', '#EC4899', '#06B6D4', '#84CC16'];

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah',
                    'data' => $data ?: [0],
                    'backgroundColor' => array_slice($colors, 0, count($data) ?: 1),
                    'borderRadius' => 6,
                ],
            ],
            'labels' => $labels ?: ['Belum ada data'],
        ];
    }
}
