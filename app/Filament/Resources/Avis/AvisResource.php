<?php

namespace App\Filament\Resources\Avis;

use App\Filament\Resources\Avis\Pages\CreateAvis;
use App\Filament\Resources\Avis\Pages\EditAvis;
use App\Filament\Resources\Avis\Pages\ListAvis;
use App\Filament\Resources\Avis\Schemas\AvisForm;
use App\Filament\Resources\Avis\Tables\AvisTable;
use App\Models\Avis as AvisModel;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AvisResource extends Resource
{
    protected static ?string $model = AvisModel::class;

    protected static ?string $slug = 'avis';

    protected static ?string $modelLabel = 'avis';

    protected static ?string $pluralModelLabel = 'avis';

    protected static ?int $navigationSort = 9;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedStar;

    public static function form(Schema $schema): Schema
    {
        return AvisForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AvisTable::configure($table);
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
            'index' => ListAvis::route('/'),
            'create' => CreateAvis::route('/create'),
            'edit' => EditAvis::route('/{record}/edit'),
        ];
    }
}
