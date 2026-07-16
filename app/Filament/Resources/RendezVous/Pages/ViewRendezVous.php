<?php

namespace App\Filament\Resources\RendezVous\Pages;

use App\Filament\Resources\RendezVous\RendezVousResource;
use App\Models\RendezVous;
use Filament\Actions\Action;
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
            Action::make('appeler')
                ->label('Appeler')
                ->icon('heroicon-o-phone')
                ->color('success')
                ->url(fn (RendezVous $record) => 'tel:'.$record->client->tel)
                ->visible(fn (RendezVous $record) => filled($record->client?->tel)),
            Action::make('itineraire')
                ->label('Itinéraire')
                ->icon('heroicon-o-map-pin')
                ->color('info')
                ->url(fn (RendezVous $record) => 'https://www.google.com/maps/search/?api=1&query='.urlencode($record->client->adresse))
                ->openUrlInNewTab()
                ->visible(fn (RendezVous $record) => filled($record->client?->adresse)),
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
                        TextEntry::make('client.tel')
                            ->label('Téléphone')
                            ->placeholder('—'),
                        TextEntry::make('client.adresse')
                            ->label('Adresse')
                            ->placeholder('—'),
                        TextEntry::make('status')->label('Statut')->badge(),
                        TextEntry::make('notes')->label('Notes')->columnSpanFull()
                            ->placeholder('—'),
                    ]),
            ]);
    }
}
