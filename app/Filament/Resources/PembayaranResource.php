<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PembayaranResource\Pages;
use App\Models\Pembayaran;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PembayaranResource extends Resource
{
    protected static ?string $model = Pembayaran::class;
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationGroup = 'Transaksi & Reservasi';
    protected static ?string $navigationLabel = 'Pembayaran';
    protected static ?string $pluralModelLabel = 'Data Pembayaran';
    protected static ?string $modelLabel = 'Pembayaran';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('id_reservasi')
                    ->label('ID Reservasi')
                    ->relationship('reservasi', 'id_reservasi')
                    ->required(),
                Forms\Components\TextInput::make('metode_bayar')
                    ->label('Metode Pembayaran')
                    ->placeholder('BCA / Mandiri / QRIS')
                    ->required(),
                Forms\Components\TextInput::make('jumlah_bayar')
                    ->label('Jumlah Bayar')
                    ->numeric()
                    ->prefix('Rp')
                    ->required(),
                Forms\Components\DateTimePicker::make('waktu_bayar')
                    ->label('Waktu Pembayaran'),
                Forms\Components\Select::make('status_bayar')
                    ->label('Status Pembayaran')
                    ->options([
                        'Belum Bayar' => 'Belum Bayar',
                        'Lunas' => 'Lunas',
                        'Gagal' => 'Gagal',
                        'Refund' => 'Refund',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id_reservasi')
                    ->label('ID Reservasi')
                    ->formatStateUsing(fn ($state) => '#WST-' . str_pad($state, 4, '0', STR_PAD_LEFT)),
                Tables\Columns\TextColumn::make('metode_bayar')
                    ->label('Metode'),
                Tables\Columns\TextColumn::make('jumlah_bayar')
                    ->label('Nominal')
                    ->money('IDR', locale: 'id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('waktu_bayar')
                    ->label('Waktu Bayar')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status_bayar')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Lunas' => 'success',
                        'Belum Bayar' => 'warning',
                        'Gagal' => 'danger',
                        'Refund' => 'info',
                        default => 'gray',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status_bayar')
                    ->options([
                        'Lunas' => 'Lunas',
                        'Belum Bayar' => 'Belum Bayar',
                        'Gagal' => 'Gagal',
                        'Refund' => 'Refund',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPembayarans::route('/'),
            'create' => Pages\CreatePembayaran::route('/create'),
            'edit' => Pages\EditPembayaran::route('/{record}/edit'),
        ];
    }
}
