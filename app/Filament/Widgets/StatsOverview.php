<?php

namespace App\Filament\Widgets;

use App\Models\PaketTur;
use App\Models\PemanduLokal;
use App\Models\Pembayaran;
use App\Models\ReservasiTur;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalPemandu = PemanduLokal::count();
        $pemanduMenunggu = PemanduLokal::where('status_verifikasi', 'Menunggu')->count();
        $totalPaket = PaketTur::count();
        $totalReservasi = ReservasiTur::count();
        $totalOmset = Pembayaran::where('status_bayar', 'Lunas')->sum('jumlah_bayar');

        return [
            Stat::make('Pemandu Lokal', $totalPemandu)
                ->description($pemanduMenunggu > 0 ? "{$pemanduMenunggu} butuh verifikasi" : 'Semua terverifikasi')
                ->descriptionIcon('heroicon-m-user-group')
                ->color($pemanduMenunggu > 0 ? 'warning' : 'success'),

            Stat::make('Paket Tur Privat', $totalPaket)
                ->description('Pengalaman unik tersedia')
                ->descriptionIcon('heroicon-m-map')
                ->color('info'),

            Stat::make('Total Reservasi', $totalReservasi)
                ->description('Booking wisatawan')
                ->descriptionIcon('heroicon-m-clipboard-document-check')
                ->color('primary'),

            Stat::make('Total Pendapatan (Omset)', 'Rp ' . number_format($totalOmset, 0, ',', '.'))
                ->description('Transaksi lunas')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
        ];
    }
}
