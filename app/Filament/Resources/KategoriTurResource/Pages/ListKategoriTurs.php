<?php

namespace App\Filament\Resources\KategoriTurResource\Pages;

use App\Filament\Resources\KategoriTurResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKategoriTurs extends ListRecords
{
    protected static string $resource = KategoriTurResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
