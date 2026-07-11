<?php

namespace App\Filament\Resources\Clients\Pages;

use App\Filament\Resources\Clients\ClientResource;
use Filament\Actions\EditAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ViewClient extends ViewRecord
{
    protected static string $resource = ClientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns(2)
                    ->components([
                        TextEntry::make('prenom')->label('Prénom'),
                        TextEntry::make('nom')->label('Nom'),
                        TextEntry::make('email')->label('Email'),
                        TextEntry::make('tel')->label('Téléphone'),
                        TextEntry::make('adresse')->label('Adresse')->columnSpanFull(),
                        TextEntry::make('prestation')->label('Prestation souhaitée'),
                        TextEntry::make('status')->label('Statut')->badge(),
                        TextEntry::make('created_at')->label('Client depuis')->date('d/m/Y'),
                        TextEntry::make('notes')->label('Notes')->columnSpanFull()
                            ->placeholder('—'),
                    ]),
            ]);
    }
}
