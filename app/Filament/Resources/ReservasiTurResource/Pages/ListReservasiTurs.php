<?php

namespace App\Filament\Resources\ReservasiTurResource\Pages;

use App\Filament\Resources\ReservasiTurResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReservasiTurs extends ListRecords
{
    protected static string $resource = ReservasiTurResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
