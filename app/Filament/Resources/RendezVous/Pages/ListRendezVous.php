<?php

namespace App\Filament\Resources\RendezVous\Pages;

use App\Filament\Resources\RendezVous\RendezVousResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRendezVous extends ListRecords
{
    protected static string $resource = RendezVousResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
