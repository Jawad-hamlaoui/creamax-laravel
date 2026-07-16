<?php

namespace App\Filament\Resources\Realisations\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class RealisationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('image_path')
                    ->label('Photo')
                    ->image()
                    ->disk('public')
                    ->directory('realisations')
                    ->imageEditor()
                    ->columnSpanFull(),
                TextInput::make('titre')
                    ->label('Titre')
                    ->required()
                    ->maxLength(150),
                TextInput::make('lieu')
                    ->label('Lieu')
                    ->maxLength(100)
                    ->placeholder('ex : Valence (26)'),
                Textarea::make('description')
                    ->label('Description')
                    ->columnSpanFull(),
                Toggle::make('featured')
                    ->label('Mettre en avant (grand format)'),
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
