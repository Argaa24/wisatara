<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaketTurResource\Pages;
use App\Models\PaketTur;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PaketTurResource extends Resource
{
    protected static ?string $model = PaketTur::class;
    protected static ?string $navigationIcon = 'heroicon-o-map';
    protected static ?string $navigationGroup = 'Mitra Pemandu';
    protected static ?string $navigationLabel = 'Paket Tur Privat';
    protected static ?string $pluralModelLabel = 'Paket Tur Privat';
    protected static ?string $modelLabel = 'Paket Tur';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Paket Tur')
                    ->schema([
                        Forms\Components\TextInput::make('judul_tur')
                            ->label('Judul Paket Pengalaman (Experience)')
                            ->required()
                            ->maxLength(150)
                            ->columnSpanFull(),

                        Forms\Components\Select::make('id_pemandu')
                            ->label('Pemandu Lokal')
                            ->relationship('pemandu', 'nama_pemandu')
                            ->searchable()
                            ->required(),

                        Forms\Components\Select::make('id_kategori')
                            ->label('Kategori Pengalaman')
                            ->relationship('kategori', 'nama_kategori')
                            ->required(),

                        Forms\Components\Select::make('id_kota')
                            ->label('Kota Destinasi')
                            ->relationship('kota', 'nama_kota')
                            ->required(),

                        Forms\Components\TextInput::make('harga_per_orang')
                            ->label('Tarif per Orang (Rp)')
                            ->numeric()
                            ->prefix('Rp')
                            ->required(),

                        Forms\Components\TextInput::make('durasi_jam')
                            ->label('Durasi Tur (Jam)')
                            ->numeric()
                            ->suffix('Jam')
                            ->default(3)
                            ->required(),

                        Forms\Components\TextInput::make('kuota_maksimal')
                            ->label('Batas Maksimal Peserta')
                            ->numeric()
                            ->suffix('Orang')
                            ->default(6)
                            ->required(),

                        Forms\Components\TextInput::make('titik_kumpul')
                            ->label('Titik Lokasi Bertemu (Meeting Point)')
                            ->required()
                            ->maxLength(150),

                        Forms\Components\Toggle::make('bisa_kustom')
                            ->label('Dapat Dikustomisasi Rutenya (100% Personalized)')
                            ->default(true),

                        Forms\Components\TextInput::make('foto_sampul')
                            ->label('URL Foto Sampul')
                            ->url()
                            ->placeholder('https://...'),

                        Forms\Components\Textarea::make('deskripsi_tur')
                            ->label('Deskripsi Lengkap Tur')
                            ->rows(4)
                            ->columnSpanFull()
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Rute Titik Singgah (Itinerary Stops)')
                    ->description('Daftar perhentian spot kunjungan beserta cerita aktivitas pada tur ini.')
                    ->schema([
                        Forms\Components\Repeater::make('itinerary')
                            ->relationship()
                            ->schema([
                                Forms\Components\TextInput::make('urutan_ke')
                                    ->label('Urutan')
                                    ->numeric()
                                    ->required()
                                    ->default(1),
                                Forms\Components\TextInput::make('nama_lokasi_spot')
                                    ->label('Nama Spot / Lokasi')
                                    ->required(),
                                Forms\Components\TextInput::make('estimasi_menit')
                                    ->label('Estimasi Menit')
                                    ->numeric()
                                    ->suffix('Menit')
                                    ->default(45),
                                Forms\Components\Textarea::make('aktivitas_cerita')
                                    ->label('Aktivitas & Cerita di Lokasi')
                                    ->columnSpanFull()
                                    ->required(),
                            ])
                            ->columns(3)
                            ->orderColumn('urutan_ke')
                            ->collapsible()
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('foto_sampul')
                    ->label('Sampul')
                    ->square(),
                Tables\Columns\TextColumn::make('judul_tur')
                    ->label('Judul Paket Tur')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('pemandu.nama_pemandu')
                    ->label('Pemandu')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kategori.nama_kategori')
                    ->label('Kategori')
                    ->badge()
                    ->color('warning'),
                Tables\Columns\TextColumn::make('harga_per_orang')
                    ->label('Tarif / Orang')
                    ->money('IDR', locale: 'id')
                    ->sortable(),
                Tables\Columns\IconColumn::make('bisa_kustom')
                    ->label('Bisa Kustom')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('id_kategori')
                    ->label('Kategori')
                    ->relationship('kategori', 'nama_kategori'),
                Tables\Filters\SelectFilter::make('id_kota')
                    ->label('Kota')
                    ->relationship('kota', 'nama_kota'),
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
            'index' => Pages\ListPaketTurs::route('/'),
            'create' => Pages\CreatePaketTur::route('/create'),
            'edit' => Pages\EditPaketTur::route('/{record}/edit'),
        ];
    }
}
