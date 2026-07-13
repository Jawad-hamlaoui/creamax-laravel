<?php

namespace App\Filament\Resources\RendezVous\Tables;

use App\Enums\RendezVousStatus;
use App\Models\RendezVous;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class RendezVousTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('client.nom_complet')
                    ->label('Client')
                    ->formatStateUsing(fn ($record) => $record->client
                        ? "{$record->client->prenom} {$record->client->nom}"
                        : null)
                    ->placeholder('Client non renseigné'),
                TextColumn::make('date_heure')
                    ->label('Date et heure')
                    ->dateTime('d/m/Y H:i')
                    ->placeholder('À définir')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Statut')
                    ->badge(),
                TextColumn::make('notes')
                    ->label('Notes')
                    ->limit(50)
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Créé le')
                    ->date('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Statut')
                    ->options(RendezVousStatus::class),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('valider')
                    ->label('Valider')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (RendezVous $record) => $record->status === RendezVousStatus::EnAttente)
                    ->requiresConfirmation()
                    ->action(fn (RendezVous $record) => $record->update(['status' => RendezVousStatus::Valide])),
                Action::make('refuser')
                    ->label('Refuser')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn (RendezVous $record) => $record->status === RendezVousStatus::EnAttente)
                    ->requiresConfirmation()
                    ->action(fn (RendezVous $record) => $record->update(['status' => RendezVousStatus::Refuse])),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('date_heure');
    }
}
