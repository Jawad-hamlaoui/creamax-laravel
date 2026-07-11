<?php

namespace App\Filament\Resources\Devis\Tables;

use App\Enums\DevisStatus;
use App\Models\Devis;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DevisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('numero')
                    ->label('N° Devis')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query
                            ->where('numero', 'like', "%{$search}%")
                            ->orWhereHas('client', function (Builder $clientQuery) use ($search) {
                                $clientQuery
                                    ->whereRaw("CONCAT(prenom, ' ', nom) LIKE ?", ["%{$search}%"]);
                            });
                    })
                    ->weight('bold'),
                TextColumn::make('client.nom_complet')
                    ->label('Client')
                    ->formatStateUsing(fn ($record) => $record->client
                        ? "{$record->client->prenom} {$record->client->nom}"
                        : null)
                    ->description(fn ($record) => $record->client?->email)
                    ->placeholder('Client introuvable'),
                TextColumn::make('total')
                    ->label('Montant TTC')
                    ->money('EUR')
                    ->weight('bold')
                    ->color('success'),
                TextColumn::make('status')
                    ->label('Statut')
                    ->badge(),
                TextColumn::make('date_creation')
                    ->label('Date')
                    ->date('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Statut')
                    ->options(DevisStatus::class),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('markSent')
                    ->label('Marquer envoyé')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('info')
                    ->visible(fn (Devis $record) => $record->status === DevisStatus::Brouillon)
                    ->action(fn (Devis $record) => $record->update(['status' => DevisStatus::Envoye]))
                    ->requiresConfirmation(),
                Action::make('downloadPdf')
                    ->label('PDF')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('gray')
                    ->action(fn (Devis $record) => response()->streamDownload(
                        fn () => print (Pdf::loadView('pdf.devis', ['devis' => $record])->setPaper('a4')->output()),
                        "{$record->numero}.pdf"
                    )),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
