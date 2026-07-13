<?php

namespace App\Filament\Resources\RendezVous\Pages;

use App\Filament\Resources\RendezVous\RendezVousResource;
use Filament\Actions\EditAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ViewRendezVous extends ViewRecord
{
    protected static string $resource = RendezVousResource::class;

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
                        TextEntry::make('client.nom_complet')
                            ->label('Client')
                            ->formatStateUsing(fn ($record) => $record->client
                                ? "{$record->client->prenom} {$record->client->nom}"
                                : null)
                            ->placeholder('Client non renseigné'),
                        TextEntry::make('date_heure')
                            ->label('Date et heure')
                            ->dateTime('d/m/Y H:i')
                            ->placeholder('À définir'),
                        TextEntry::make('status')->label('Statut')->badge(),
                        TextEntry::make('notes')->label('Notes')->columnSpanFull()
                            ->placeholder('—'),
                    ]),
            ]);
    }
}
