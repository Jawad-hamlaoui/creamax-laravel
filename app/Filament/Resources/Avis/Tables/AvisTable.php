<?php

namespace App\Filament\Resources\Avis\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AvisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nom_client')
                    ->label('Client')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('note')
                    ->label('Note')
                    ->formatStateUsing(fn (int $state) => str_repeat('★', $state)),
                TextColumn::make('texte')
                    ->label('Avis')
                    ->limit(60),
                IconColumn::make('actif')
                    ->label('Visible')
                    ->boolean(),
                TextColumn::make('ordre')
                    ->label('Ordre')
                    ->sortable(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->reorderable('ordre')
            ->defaultSort('ordre');
    }
}
