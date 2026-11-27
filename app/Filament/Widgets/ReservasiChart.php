<?php

namespace App\Filament\Widgets;

use App\Models\ReservasiTur;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class ReservasiChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Reservasi Tur (6 Bulan Terakhir)';

    protected static ?int $sort = 2;

    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $labels = [];
        $jumlahReservasi = [];

        for ($i = 5; $i >= 0; $i--) {
            $bulan = Carbon::now()->subMonths($i);
            $labels[] = $bulan->translatedFormat('M Y');

            $count = ReservasiTur::whereBetween('created_at', [
                $bulan->copy()->startOfMonth(),
                $bulan->copy()->endOfMonth(),
            ])->count();

            $jumlahReservasi[] = $count;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Reservasi',
                    'data' => $jumlahReservasi,
                    'borderColor' => '#f59e0b',
                    'backgroundColor' => 'rgba(245, 158, 11, 0.18)',
                    'fill' => true,
                    'tension' => 0.35,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
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
