<?php

namespace App\Filament\Resources\PaketTurResource\Pages;

use App\Filament\Resources\PaketTurResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPaketTur extends EditRecord
{
    protected static string $resource = PaketTurResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
