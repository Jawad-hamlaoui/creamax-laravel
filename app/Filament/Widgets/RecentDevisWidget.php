<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Devis\DevisResource;
use App\Models\Devis;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class RecentDevisWidget extends TableWidget
{
    protected static ?string $heading = 'Derniers devis';

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 1;

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Devis::query()->latest('created_at')->limit(5))
            ->paginated(false)
            ->columns([
                TextColumn::make('numero')->label('N° Devis'),
                TextColumn::make('client.nom_complet')
                    ->label('Client')
                    ->formatStateUsing(fn ($record) => $record->client
                        ? "{$record->client->prenom} {$record->client->nom}"
                        : 'Client introuvable'),
                TextColumn::make('total')->label('Montant')->money('EUR'),
                TextColumn::make('status')->label('Statut')->badge(),
                TextColumn::make('date_creation')->label('Date')->date('d/m/Y'),
            ])
            ->recordActions([
                Action::make('voir')
                    ->label('Voir')
                    ->url(fn (Devis $record) => DevisResource::getUrl('view', ['record' => $record])),
            ]);
    }
}
