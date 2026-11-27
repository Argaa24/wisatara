<?php

namespace App\Filament\Widgets;

use App\Models\PemanduLokal;
use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class PendingPemanduWidget extends BaseWidget
{
    protected static ?string $heading = 'ACC Pemandu Lokal Baru (Menunggu Verifikasi)';

    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                PemanduLokal::query()
                    ->with('kota')
                    ->where('status_verifikasi', 'Menunggu')
                    ->latest()
            )
            ->emptyStateHeading('Semua pemandu lokal sudah terverifikasi')
            ->emptyStateDescription('Pendaftar pemandu baru akan muncul otomatis di sini untuk di-ACC.')
            ->emptyStateIcon('heroicon-o-check-badge')
            ->columns([
                Tables\Columns\ImageColumn::make('foto_profil')
                    ->label('Foto')
                    ->circular()
                    ->defaultImageUrl('https://ui-avatars.com/api/?name=Guide&background=0D8ABC&color=fff'),
                Tables\Columns\TextColumn::make('nama_pemandu')
                    ->label('Nama Pemandu')
                    ->weight('bold')
                    ->description(fn (PemanduLokal $record): string => $record->tagline_pemandu ?? '-'),
                Tables\Columns\TextColumn::make('kota.nama_kota')
                    ->label('Kota Destinasi')
                    ->badge()
                    ->color('info'),
                Tables\Columns\TextColumn::make('no_hp')
                    ->label('Kontak'),
                Tables\Columns\TextColumn::make('status_verifikasi')
                    ->label('Status')
                    ->badge()
                    ->color('warning'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Mendaftar')
                    ->since(),
            ])
            ->actions([
                Tables\Actions\Action::make('acc')
                    ->label('ACC Pemandu')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->button()
                    ->requiresConfirmation()
                    ->modalHeading('ACC & Verifikasi Pemandu Lokal?')
                    ->modalDescription(fn (PemanduLokal $record) => "Pemandu {$record->nama_pemandu} akan langsung berstatus Terverifikasi dan tampil di halaman publik Wisatara.")
                    ->action(function (PemanduLokal $record) {
                        $record->update(['status_verifikasi' => 'Terverifikasi']);

                        Notification::make()
                            ->title("Pemandu {$record->nama_pemandu} berhasil di-ACC!")
                            ->success()
                            ->send();
                    }),

                Tables\Actions\Action::make('tolak')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function (PemanduLokal $record) {
                        $record->update(['status_verifikasi' => 'Ditolak']);

                        Notification::make()
                            ->title("Pendaftaran {$record->nama_pemandu} ditolak.")
                            ->danger()
                            ->send();
                    }),
            ])
            ->paginated([5, 10]);
    }
}
