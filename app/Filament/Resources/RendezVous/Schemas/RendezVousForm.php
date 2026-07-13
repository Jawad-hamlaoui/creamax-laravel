<?php

namespace App\Filament\Resources\RendezVous\Schemas;

use App\Enums\RendezVousStatus;
use App\Models\Client;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class RendezVousForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('client_id')
                    ->label('Client')
                    ->options(fn () => Client::query()
                        ->get()
                        ->mapWithKeys(fn (Client $client) => [$client->id => "{$client->prenom} {$client->nom}"]))
                    ->searchable()
                    ->native(false),
                DateTimePicker::make('date_heure')
                    ->label('Date et heure')
                    ->native(false),
                Select::make('status')
                    ->label('Statut')
                    ->options(RendezVousStatus::class)
                    ->default(RendezVousStatus::EnAttente)
                    ->native(false)
                    ->required(),
                Textarea::make('notes')
                    ->label('Notes')
                    ->columnSpanFull(),
            ])
            ->columns(2);
    }
}
