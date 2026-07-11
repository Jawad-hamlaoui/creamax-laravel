<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Clients\ClientResource;
use App\Models\Client;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class RecentClientsWidget extends TableWidget
{
    protected static ?string $heading = 'Derniers clients';

    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 1;

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Client::query()->latest('created_at')->limit(5))
            ->paginated(false)
            ->columns([
                TextColumn::make('prenom')
                    ->label('Client')
                    ->formatStateUsing(fn ($record) => "{$record->prenom} {$record->nom}"),
                TextColumn::make('prestation')->label('Prestation'),
                TextColumn::make('status')->label('Statut')->badge(),
                TextColumn::make('created_at')->label('Depuis')->date('d/m/Y'),
            ])
            ->recordActions([
                Action::make('voir')
                    ->label('Voir')
                    ->url(fn (Client $record) => ClientResource::getUrl('view', ['record' => $record])),
            ]);
    }
}
