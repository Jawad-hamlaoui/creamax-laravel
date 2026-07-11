<?php

namespace App\Filament\Resources\Prestations\Pages;

use App\Filament\Resources\Prestations\PrestationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPrestation extends EditRecord
{
    protected static string $resource = PrestationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
