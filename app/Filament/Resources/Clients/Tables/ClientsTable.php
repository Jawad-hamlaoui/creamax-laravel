<?php

namespace App\Filament\Resources\Clients\Tables;

use App\Enums\ClientStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ClientsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('prenom')
                    ->label('Client')
                    ->formatStateUsing(fn ($record) => "{$record->prenom} {$record->nom}")
                    ->description(fn ($record) => $record->email)
                    ->searchable(['prenom', 'nom', 'email']),
                TextColumn::make('tel')
                    ->label('Téléphone'),
                TextColumn::make('prestation')
                    ->label('Prestation souhaitée')
                    ->badge()
                    ->color('gray'),
                TextColumn::make('status')
                    ->label('Statut')
                    ->badge(),
                TextColumn::make('created_at')
                    ->label('Depuis')
                    ->date('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Statut')
                    ->options(ClientStatus::class),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
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
