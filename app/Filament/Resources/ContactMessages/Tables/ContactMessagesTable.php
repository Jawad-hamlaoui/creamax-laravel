<?php

namespace App\Filament\Resources\ContactMessages\Tables;

use App\Enums\ContactMessageStatus;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ContactMessagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('prenom')
                    ->label('Contact')
                    ->formatStateUsing(fn ($record) => "{$record->prenom} {$record->nom}")
                    ->description(fn ($record) => $record->email)
                    ->searchable(['prenom', 'nom', 'email']),
                TextColumn::make('telephone')
                    ->label('Téléphone'),
                TextColumn::make('commune')
                    ->label('Commune'),
                TextColumn::make('prestation')
                    ->label('Prestation'),
                IconColumn::make('audio_path')
                    ->label('Vocal')
                    ->boolean()
                    ->trueIcon('heroicon-o-microphone')
                    ->falseIcon('heroicon-o-minus'),
                TextColumn::make('status')
                    ->label('Statut')
                    ->badge(),
                TextColumn::make('created_at')
                    ->label('Reçu le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Statut')
                    ->options(ContactMessageStatus::class),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make()
                    ->label('Statut'),
                DeleteAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
