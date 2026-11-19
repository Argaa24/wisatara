<?php

namespace App\Filament\Resources\PemanduLokalResource\Pages;

use App\Filament\Resources\PemanduLokalResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPemanduLokals extends ListRecords
{
    protected static string $resource = PemanduLokalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
