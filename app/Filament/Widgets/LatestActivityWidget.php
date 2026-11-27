<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ReservasiTurResource;
use App\Models\ReservasiTur;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestActivityWidget extends BaseWidget
{
    protected static ?string $heading = 'Aktivitas Reservasi Terbaru';

    protected static ?int $sort = 5;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                ReservasiTur::query()
                    ->with(['wisatawan', 'paket', 'pemandu', 'pembayaran'])
                    ->latest()
            )
            ->defaultPaginationPageOption(5)
            ->columns([
                Tables\Columns\TextColumn::make('id_reservasi')
                    ->label('Kode')
                    ->weight('bold')
                    ->formatStateUsing(fn ($state) => '#WST-' . str_pad($state, 4, '0', STR_PAD_LEFT)),
                Tables\Columns\TextColumn::make('wisatawan.nama_lengkap')
                    ->label('Wisatawan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('paket.judul_tur')
                    ->label('Paket Tur')
                    ->limit(32)
                    ->tooltip(fn (ReservasiTur $record) => $record->paket?->judul_tur),
                Tables\Columns\TextColumn::make('pemandu.nama_pemandu')
                    ->label('Pemandu'),
                Tables\Columns\TextColumn::make('tgl_tur')
                    ->label('Tanggal Tur')
                    ->date('d M Y'),
                Tables\Columns\TextColumn::make('total_harga')
                    ->label('Total Biaya')
                    ->money('IDR', locale: 'id'),
                Tables\Columns\TextColumn::make('status_reservasi')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Selesai' => 'success',
                        'Dikonfirmasi' => 'info',
                        'Menunggu' => 'warning',
                        'Ditolak', 'Dibatalkan' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu')
                    ->since(),
            ])
            ->actions([
                Tables\Actions\Action::make('lihat')
                    ->label('Kelola')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->url(fn (ReservasiTur $record): string => ReservasiTurResource::getUrl('edit', ['record' => $record])),
            ]);
    }
}
