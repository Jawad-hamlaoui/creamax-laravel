<?php

namespace App\Filament\Resources\Clients\Schemas;

use App\Enums\ClientStatus;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ClientForm
{
    const PRESTATIONS_SOUHAITEES = [
        'Création de jardin' => 'Création de jardin',
        'Entretien jardin' => 'Entretien jardin',
        'Aménagement paysager' => 'Aménagement paysager',
        'Taille haies & arbustes' => 'Taille haies & arbustes',
        'Engazonnement' => 'Engazonnement',
        'Autre' => 'Autre',
    ];

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('prenom')
                    ->label('Prénom')
                    ->required()
                    ->maxLength(100),
                TextInput::make('nom')
                    ->label('Nom')
                    ->required()
                    ->maxLength(100),
                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->maxLength(150),
                TextInput::make('tel')
                    ->label('Téléphone')
                    ->tel()
                    ->required()
                    ->maxLength(30),
                TextInput::make('adresse')
                    ->label('Adresse postale')
                    ->maxLength(255)
                    ->columnSpanFull(),
                Select::make('prestation')
                    ->label('Prestation souhaitée')
                    ->options(self::PRESTATIONS_SOUHAITEES)
                    ->native(false),
                Select::make('status')
                    ->label('Statut')
                    ->options(ClientStatus::class)
                    ->default(ClientStatus::Nouveau)
                    ->native(false)
                    ->required(),
                Textarea::make('notes')
                    ->label('Notes')
                    ->columnSpanFull(),
            ])
            ->columns(2);
    }
}
