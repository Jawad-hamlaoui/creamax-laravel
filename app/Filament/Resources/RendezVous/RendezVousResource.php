<?php

namespace App\Filament\Resources\RendezVous;

use App\Filament\Resources\RendezVous\Pages\CreateRendezVous;
use App\Filament\Resources\RendezVous\Pages\EditRendezVous;
use App\Filament\Resources\RendezVous\Pages\ListRendezVous;
use App\Filament\Resources\RendezVous\Pages\ViewRendezVous;
use App\Filament\Resources\RendezVous\Schemas\RendezVousForm;
use App\Filament\Resources\RendezVous\Tables\RendezVousTable;
use App\Models\RendezVous as RendezVousModel;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RendezVousResource extends Resource
{
    protected static ?string $model = RendezVousModel::class;

    protected static ?string $slug = 'rendez-vous';

    protected static ?string $modelLabel = 'rendez-vous';

    protected static ?string $pluralModelLabel = 'rendez-vous';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    public static function form(Schema $schema): Schema
    {
        return RendezVousForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RendezVousTable::configure($table);
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
            'index' => ListRendezVous::route('/'),
            'create' => CreateRendezVous::route('/create'),
            'view' => ViewRendezVous::route('/{record}'),
            'edit' => EditRendezVous::route('/{record}/edit'),
        ];
    }
}
