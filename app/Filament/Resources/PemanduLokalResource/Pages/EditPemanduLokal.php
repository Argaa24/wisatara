<?php

namespace App\Filament\Resources\PemanduLokalResource\Pages;

use App\Filament\Resources\PemanduLokalResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPemanduLokal extends EditRecord
{
    protected static string $resource = PemanduLokalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
