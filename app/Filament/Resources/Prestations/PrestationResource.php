<?php

namespace App\Filament\Resources\Prestations;

use App\Filament\Resources\Prestations\Pages\CreatePrestation;
use App\Filament\Resources\Prestations\Pages\EditPrestation;
use App\Filament\Resources\Prestations\Pages\ListPrestations;
use App\Filament\Resources\Prestations\Schemas\PrestationForm;
use App\Filament\Resources\Prestations\Tables\PrestationsTable;
use App\Models\Prestation;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PrestationResource extends Resource
{
    protected static ?string $model = Prestation::class;

    protected static ?string $modelLabel = 'prestation';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSparkles;

    public static function form(Schema $schema): Schema
    {
        return PrestationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PrestationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPrestations::route('/'),
            'create' => CreatePrestation::route('/create'),
            'edit' => EditPrestation::route('/{record}/edit'),
        ];
    }
}
