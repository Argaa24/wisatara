<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KategoriTurResource\Pages;
use App\Models\KategoriTur;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class KategoriTurResource extends Resource
{
    protected static ?string $model = KategoriTur::class;
    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?string $navigationLabel = 'Kategori Tur';
    protected static ?string $pluralModelLabel = 'Kategori Tur';
    protected static ?string $modelLabel = 'Kategori Tur';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_kategori')
                    ->label('Nama Kategori Pengalaman')
                    ->required()
                    ->maxLength(100),
                Forms\Components\Textarea::make('deskripsi')
                    ->label('Deskripsi')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_kategori')
                    ->label('Kategori')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('deskripsi')
                    ->label('Deskripsi')
                    ->limit(60),
                Tables\Columns\TextColumn::make('paket_tur_count')
                    ->label('Total Paket')
                    ->counts('paketTur')
                    ->badge(),
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
            'index' => Pages\ListKategoriTurs::route('/'),
            'create' => Pages\CreateKategoriTur::route('/create'),
            'edit' => Pages\EditKategoriTur::route('/{record}/edit'),
        ];
    }
}
