<?php

namespace App\Filament\Resources\Clients\RelationManagers;

use App\Filament\Resources\Devis\DevisResource;
use Filament\Actions\Action;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DevisRelationManager extends RelationManager
{
    protected static string $relationship = 'devis';

    protected static ?string $title = 'Devis';

    public function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('numero')
            ->columns([
                TextColumn::make('numero')
                    ->label('N° Devis'),
                TextColumn::make('total')
                    ->label('Montant TTC')
                    ->money('EUR'),
                TextColumn::make('status')
                    ->label('Statut')
                    ->badge(),
                TextColumn::make('date_creation')
                    ->label('Date')
                    ->date('d/m/Y'),
            ])
            ->headerActions([])
            ->recordActions([
                Action::make('voir')
                    ->label('Voir →')
                    ->url(fn ($record) => DevisResource::getUrl('edit', ['record' => $record]))
                    ->icon('heroicon-o-eye'),
            ])
            ->toolbarActions([])
            ->defaultSort('date_creation', 'desc');
    }
}
