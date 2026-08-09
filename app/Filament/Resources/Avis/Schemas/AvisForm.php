<?php

namespace App\Filament\Resources\Avis\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AvisForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nom_client')
                    ->label('Nom du client')
                    ->required()
                    ->maxLength(150),
                Select::make('note')
                    ->label('Note')
                    ->options([
                        5 => '★★★★★ (5)',
                        4 => '★★★★ (4)',
                        3 => '★★★ (3)',
                        2 => '★★ (2)',
                        1 => '★ (1)',
                    ])
                    ->default(5)
                    ->native(false)
                    ->required(),
                Textarea::make('texte')
                    ->label('Texte de l\'avis')
                    ->helperText('Copie le texte exact de l\'avis Google — pas d\'avis inventé.')
                    ->required()
                    ->columnSpanFull(),
                Toggle::make('actif')
                    ->label('Visible sur le site')
                    ->default(true),
                TextInput::make('ordre')
                    ->label('Ordre d\'affichage')
                    ->numeric()
                    ->default(0),
            ])
            ->columns(2);
    }
}
