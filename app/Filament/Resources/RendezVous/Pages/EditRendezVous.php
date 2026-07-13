<?php

namespace App\Filament\Resources\RendezVous\Pages;

use App\Filament\Resources\RendezVous\RendezVousResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRendezVous extends EditRecord
{
    protected static string $resource = RendezVousResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
