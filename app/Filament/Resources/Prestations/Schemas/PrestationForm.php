<?php

namespace App\Filament\Resources\Prestations\Schemas;

use App\Enums\PrestationCategorie;
use App\Enums\PrestationUnite;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PrestationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('titre')
                    ->label('Titre')
                    ->required()
                    ->maxLength(150),
                Select::make('categorie')
                    ->label('Catégorie')
                    ->options(PrestationCategorie::class)
                    ->native(false)
                    ->required(),
                TextInput::make('prix')
                    ->label('Prix unitaire')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->step(0.01)
                    ->suffix('€'),
                Select::make('unite')
                    ->label('Unité')
                    ->options(PrestationUnite::class)
                    ->native(false)
                    ->required(),
                Textarea::make('description')
                    ->label('Description')
                    ->columnSpanFull(),
            ])
            ->columns(2);
    }
}
