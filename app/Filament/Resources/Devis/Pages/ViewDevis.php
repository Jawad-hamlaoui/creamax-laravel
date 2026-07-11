<?php

namespace App\Filament\Resources\Devis\Pages;

use App\Filament\Resources\Devis\DevisResource;
use App\Models\Devis;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ViewDevis extends ViewRecord
{
    protected static string $resource = DevisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('downloadPdf')
                ->label('Télécharger le PDF')
                ->icon('heroicon-o-arrow-down-tray')
                ->action(fn (Devis $record) => response()->streamDownload(
                    fn () => print (Pdf::loadView('pdf.devis', ['devis' => $record])->setPaper('a4')->output()),
                    "{$record->numero}.pdf"
                )),
            EditAction::make(),
        ];
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns(3)
                    ->components([
                        TextEntry::make('numero')->label('N° Devis'),
                        TextEntry::make('client.nom_complet')
                            ->label('Client')
                            ->state(fn (Devis $record) => $record->client
                                ? "{$record->client->prenom} {$record->client->nom}"
                                : 'Client introuvable'),
                        TextEntry::make('status')->label('Statut')->badge(),
                        TextEntry::make('date_creation')->label('Date')->date('d/m/Y'),
                        TextEntry::make('validite_jours')->label('Validité')->suffix(' jours'),
                        TextEntry::make('total')->label('Montant TTC')->money('EUR'),
                    ]),
                Section::make('Lignes')
                    ->components([
                        RepeatableEntry::make('lignes')
                            ->label('')
                            ->schema([
                                TextEntry::make('description')->label('Description'),
                                TextEntry::make('quantite')->label('Qté'),
                                TextEntry::make('prix_unitaire')->label('Prix unit.')->money('EUR'),
                                TextEntry::make('total')->label('Total HT')->money('EUR'),
                            ])
                            ->columns(4),
                    ]),
                Section::make('Notes')
                    ->visible(fn (Devis $record) => filled($record->notes))
                    ->components([
                        TextEntry::make('notes')->label(''),
                    ]),
            ]);
    }
}
