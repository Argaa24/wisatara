<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReservasiTurResource\Pages;
use App\Models\ReservasiTur;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ReservasiTurResource extends Resource
{
    protected static ?string $model = ReservasiTur::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationGroup = 'Transaksi & Reservasi';
    protected static ?string $navigationLabel = 'Reservasi Tur';
    protected static ?string $pluralModelLabel = 'Reservasi Tur';
    protected static ?string $modelLabel = 'Reservasi Tur';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Rincian Pemesanan Tur')
                    ->schema([
                        Forms\Components\Select::make('id_wisatawan')
                            ->label('Wisatawan (Pemesan)')
                            ->relationship('wisatawan', 'nama_lengkap')
                            ->searchable()
                            ->required(),

                        Forms\Components\Select::make('id_paket')
                            ->label('Paket Tur Dipilih')
                            ->relationship('paket', 'judul_tur')
                            ->searchable()
                            ->required(),

                        Forms\Components\Select::make('id_pemandu')
                            ->label('Pemandu Lokal')
                            ->relationship('pemandu', 'nama_pemandu')
                            ->searchable()
                            ->required(),

                        Forms\Components\DatePicker::make('tgl_tur')
                            ->label('Tanggal Tur')
                            ->required(),

                        Forms\Components\TimePicker::make('jam_mulai')
                            ->label('Jam Mulai')
                            ->required(),

                        Forms\Components\TextInput::make('jumlah_peserta')
                            ->label('Jumlah Peserta')
                            ->numeric()
                            ->default(1)
                            ->required(),

                        Forms\Components\TextInput::make('total_harga')
                            ->label('Total Harga')
                            ->prefix('Rp')
                            ->numeric()
                            ->required(),

                        Forms\Components\Select::make('status_reservasi')
                            ->label('Status Reservasi')
                            ->options([
                                'Menunggu' => 'Menunggu',
                                'Dikonfirmasi' => 'Dikonfirmasi',
                                'Ditolak' => 'Ditolak',
                                'Selesai' => 'Selesai',
                                'Dibatalkan' => 'Dibatalkan',
                            ])
                            ->default('Menunggu')
                            ->required(),

                        Forms\Components\Textarea::make('catatan_kustomisasi')
                            ->label('Catatan Permintaan Khusus / Kustomisasi Rute')
                            ->placeholder('Misal: tidak makan pedas, ingin singgah ke tempat kerajinan, dll.')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id_reservasi')
                    ->label('Kode')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => '#WST-' . str_pad($state, 4, '0', STR_PAD_LEFT)),
                Tables\Columns\TextColumn::make('wisatawan.nama_lengkap')
                    ->label('Wisatawan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('paket.judul_tur')
                    ->label('Paket Tur')
                    ->limit(25)
                    ->searchable(),
                Tables\Columns\TextColumn::make('pemandu.nama_pemandu')
                    ->label('Pemandu')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tgl_tur')
                    ->label('Tgl Tur')
                    ->date('d M Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('jumlah_peserta')
                    ->label('Pax')
                    ->suffix(' Orang'),
                Tables\Columns\TextColumn::make('total_harga')
                    ->label('Total Biaya')
                    ->money('IDR', locale: 'id')
                    ->sortable(),
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
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status_reservasi')
                    ->options([
                        'Menunggu' => 'Menunggu',
                        'Dikonfirmasi' => 'Dikonfirmasi',
                        'Selesai' => 'Selesai',
                        'Ditolak' => 'Ditolak',
                        'Dibatalkan' => 'Dibatalkan',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('confirm')
                    ->label('Konfirmasi')
                    ->icon('heroicon-o-check')
                    ->color('info')
                    ->visible(fn (ReservasiTur $record) => $record->status_reservasi === 'Menunggu')
                    ->action(fn (ReservasiTur $record) => $record->update(['status_reservasi' => 'Dikonfirmasi'])),

                Tables\Actions\Action::make('complete')
                    ->label('Selesaikan')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (ReservasiTur $record) => in_array($record->status_reservasi, ['Menunggu', 'Dikonfirmasi']))
                    ->action(fn (ReservasiTur $record) => $record->update(['status_reservasi' => 'Selesai'])),

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
            'index' => Pages\ListReservasiTurs::route('/'),
            'create' => Pages\CreateReservasiTur::route('/create'),
            'edit' => Pages\EditReservasiTur::route('/{record}/edit'),
        ];
    }
}
