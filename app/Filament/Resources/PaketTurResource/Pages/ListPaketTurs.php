<?php

namespace App\Filament\Resources\PaketTurResource\Pages;

use App\Filament\Resources\PaketTurResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPaketTurs extends ListRecords
{
    protected static string $resource = PaketTurResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
