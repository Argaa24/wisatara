<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UlasanTurResource\Pages;
use App\Models\UlasanTur;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UlasanTurResource extends Resource
{
    protected static ?string $model = UlasanTur::class;
    protected static ?string $navigationIcon = 'heroicon-o-star';
    protected static ?string $navigationGroup = 'Transaksi & Reservasi';
    protected static ?string $navigationLabel = 'Ulasan & Rating';
    protected static ?string $pluralModelLabel = 'Ulasan & Rating';
    protected static ?string $modelLabel = 'Ulasan Tur';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('id_reservasi')
                    ->label('ID Reservasi')
                    ->relationship('reservasi', 'id_reservasi')
                    ->required(),
                Forms\Components\Select::make('id_wisatawan')
                    ->label('Wisatawan')
                    ->relationship('wisatawan', 'nama_lengkap')
                    ->required(),
                Forms\Components\Select::make('id_pemandu')
                    ->label('Pemandu Lokal')
                    ->relationship('pemandu', 'nama_pemandu')
                    ->required(),
                Forms\Components\Select::make('rating')
                    ->label('Bintang Rating')
                    ->options([
                        1 => '⭐ 1 - Buruk Sekali',
                        2 => '⭐⭐ 2 - Kurang Puas',
                        3 => '⭐⭐⭐ 3 - Cukup',
                        4 => '⭐⭐⭐⭐ 4 - Sangat Puas',
                        5 => '⭐⭐⭐⭐⭐ 5 - Luar Biasa',
                    ])
                    ->required(),
                Forms\Components\DatePicker::make('tgl_ulasan')
                    ->label('Tanggal Ulasan')
                    ->default(now()),
                Forms\Components\Textarea::make('komentar')
                    ->label('Testimoni Wisatawan')
                    ->rows(3)
                    ->columnSpanFull()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pemandu.nama_pemandu')
                    ->label('Pemandu')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('wisatawan.nama_lengkap')
                    ->label('Wisatawan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rating')
                    ->label('Rating')
                    ->badge()
                    ->color('warning')
                    ->formatStateUsing(fn ($state) => str_repeat('⭐', $state) . " ($state/5)"),
                Tables\Columns\TextColumn::make('komentar')
                    ->label('Komentar')
                    ->limit(50),
                Tables\Columns\TextColumn::make('tgl_ulasan')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('rating')
                    ->options([
                        5 => '5 Bintang',
                        4 => '4 Bintang',
                        3 => '3 Bintang',
                        2 => '2 Bintang',
                        1 => '1 Bintang',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUlasanTurs::route('/'),
            'create' => Pages\CreateUlasanTur::route('/create'),
            'edit' => Pages\EditUlasanTur::route('/{record}/edit'),
        ];
    }
}
