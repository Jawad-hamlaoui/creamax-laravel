<?php

namespace App\Filament\Resources\Prestations\Pages;

use App\Filament\Resources\Prestations\PrestationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPrestations extends ListRecords
{
    protected static string $resource = PrestationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
