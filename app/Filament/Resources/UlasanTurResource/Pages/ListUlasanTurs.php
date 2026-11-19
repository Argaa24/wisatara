<?php

namespace App\Filament\Resources\UlasanTurResource\Pages;

use App\Filament\Resources\UlasanTurResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUlasanTurs extends ListRecords
{
    protected static string $resource = UlasanTurResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
