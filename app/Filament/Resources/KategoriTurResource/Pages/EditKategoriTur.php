<?php

namespace App\Filament\Resources\KategoriTurResource\Pages;

use App\Filament\Resources\KategoriTurResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKategoriTur extends EditRecord
{
    protected static string $resource = KategoriTurResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
