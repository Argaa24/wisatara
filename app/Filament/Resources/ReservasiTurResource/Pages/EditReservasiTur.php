<?php

namespace App\Filament\Resources\ReservasiTurResource\Pages;

use App\Filament\Resources\ReservasiTurResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReservasiTur extends EditRecord
{
    protected static string $resource = ReservasiTurResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
