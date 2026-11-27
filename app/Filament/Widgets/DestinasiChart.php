<?php

namespace App\Filament\Widgets;

use App\Models\KotaDestinasi;
use Filament\Widgets\ChartWidget;

class DestinasiChart extends ChartWidget
{
    protected static ?string $heading = 'Sebaran Paket Tur & Pemandu per Kota';

    protected static ?int $sort = 3;

    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $kotaList = KotaDestinasi::withCount(['paketTur', 'pemandu'])->get();

        $labels = $kotaList->pluck('nama_kota')->toArray();
        $paketCounts = $kotaList->pluck('paket_tur_count')->toArray();
        $pemanduCounts = $kotaList->pluck('pemandu_count')->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Paket Tur',
                    'data' => $paketCounts,
                    'backgroundColor' => 'rgba(245, 158, 11, 0.8)',
                    'borderColor' => '#f59e0b',
                    'borderWidth' => 1,
                ],
                [
                    'label' => 'Pemandu Lokal',
                    'data' => $pemanduCounts,
                    'backgroundColor' => 'rgba(16, 185, 129, 0.8)',
                    'borderColor' => '#10b981',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'precision' => 0,
                    ],
                ],
            ],
        ];
    }
}
