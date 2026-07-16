<?php

namespace App\Filament\Resources\Realisations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RealisationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_path')
                    ->label('Photo')
                    ->disk('public')
                    ->square(),
                TextColumn::make('titre')
                    ->label('Titre')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('lieu')
                    ->label('Lieu'),
                IconColumn::make('featured')
                    ->label('Mise en avant')
                    ->boolean(),
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
