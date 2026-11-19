<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PemanduLokalResource\Pages;
use App\Models\PemanduLokal;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PemanduLokalResource extends Resource
{
    protected static ?string $model = PemanduLokal::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Mitra Pemandu';
    protected static ?string $navigationLabel = 'Pemandu Lokal';
    protected static ?string $pluralModelLabel = 'Pemandu Lokal';
    protected static ?string $modelLabel = 'Pemandu Lokal';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Akun & Wilayah')
                    ->schema([
                        Forms\Components\Select::make('id_user')
                            ->label('Akun Pengguna')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->required(),
                        Forms\Components\Select::make('id_kota')
                            ->label('Kota Destinasi Domisili')
                            ->relationship('kota', 'nama_kota')
                            ->searchable()
                            ->required(),
                        Forms\Components\TextInput::make('nama_pemandu')
                            ->label('Nama Lengkap Pemandu')
                            ->required()
                            ->maxLength(100),
                        Forms\Components\TextInput::make('no_hp')
                            ->label('No. WhatsApp / HP')
                            ->tel()
                            ->maxLength(15),
                    ])->columns(2),

                Forms\Components\Section::make('Personal Branding & Profil')
                    ->schema([
                        Forms\Components\TextInput::make('tagline_pemandu')
                            ->label('Tagline Personal')
                            ->placeholder('contoh: The Yogyakarta Historian')
                            ->maxLength(150),
                        Forms\Components\Textarea::make('tentang_saya')
                            ->label('Bio / Cerita Tentang Saya')
                            ->rows(4)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('foto_profil')
                            ->label('URL Foto Profil')
                            ->url()
                            ->placeholder('https://...'),
                        Forms\Components\TextInput::make('video_perkenalan')
                            ->label('URL Video Perkenalan')
                            ->url()
                            ->placeholder('https://youtube.com/...'),
                    ])->columns(2),

                Forms\Components\Section::make('Status Pemandu')
                    ->schema([
                        Forms\Components\Select::make('status_verifikasi')
                            ->label('Status Verifikasi Admin')
                            ->options([
                                'Menunggu' => 'Menunggu',
                                'Terverifikasi' => 'Terverifikasi',
                                'Ditolak' => 'Ditolak',
                            ])
                            ->default('Menunggu')
                            ->required(),
                        Forms\Components\Select::make('status_ketersediaan')
                            ->label('Status Ketersediaan')
                            ->options([
                                'Tersedia' => 'Tersedia',
                                'Tidak Tersedia' => 'Tidak Tersedia',
                            ])
                            ->default('Tersedia')
                            ->required(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('foto_profil')
                    ->label('Foto')
                    ->circular()
                    ->defaultImageUrl('https://ui-avatars.com/api/?name=Guide&background=0D8ABC&color=fff'),
                Tables\Columns\TextColumn::make('nama_pemandu')
                    ->label('Nama Pemandu')
                    ->searchable()
                    ->sortable()
                    ->description(fn (PemanduLokal $record): string => $record->tagline_pemandu ?? '-'),
                Tables\Columns\TextColumn::make('kota.nama_kota')
                    ->label('Kota Destinasi')
                    ->badge()
                    ->color('info')
                    ->sortable(),
                Tables\Columns\TextColumn::make('no_hp')
                    ->label('Kontak')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status_verifikasi')
                    ->label('Verifikasi')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Terverifikasi' => 'success',
                        'Menunggu' => 'warning',
                        'Ditolak' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('status_ketersediaan')
                    ->label('Ketersediaan')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Tersedia' => 'success',
                        'Tidak Tersedia' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status_verifikasi')
                    ->options([
                        'Menunggu' => 'Menunggu',
                        'Terverifikasi' => 'Terverifikasi',
                        'Ditolak' => 'Ditolak',
                    ]),
                Tables\Filters\SelectFilter::make('id_kota')
                    ->label('Kota')
                    ->relationship('kota', 'nama_kota'),
            ])
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->label('Setujui')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (PemanduLokal $record) => $record->status_verifikasi !== 'Terverifikasi')
                    ->action(fn (PemanduLokal $record) => $record->update(['status_verifikasi' => 'Terverifikasi'])),

                Tables\Actions\Action::make('reject')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn (PemanduLokal $record) => $record->status_verifikasi === 'Menunggu')
                    ->action(fn (PemanduLokal $record) => $record->update(['status_verifikasi' => 'Ditolak'])),

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
            'index' => Pages\ListPemanduLokals::route('/'),
            'create' => Pages\CreatePemanduLokal::route('/create'),
            'edit' => Pages\EditPemanduLokal::route('/{record}/edit'),
        ];
    }
}
