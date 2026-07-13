<?php

namespace App\Filament\Resources\ContactMessages\Tables;

use App\Enums\ContactMessageStatus;
use App\Enums\RendezVousStatus;
use App\Models\ContactMessage;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ContactMessagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('prenom')
                    ->label('Contact')
                    ->formatStateUsing(fn ($record) => "{$record->prenom} {$record->nom}")
                    ->description(fn ($record) => $record->email)
                    ->searchable(['prenom', 'nom', 'email']),
                TextColumn::make('telephone')
                    ->label('Téléphone'),
                TextColumn::make('commune')
                    ->label('Commune'),
                TextColumn::make('prestation')
                    ->label('Prestation'),
                IconColumn::make('audio_path')
                    ->label('Vocal')
                    ->boolean()
                    ->trueIcon('heroicon-o-microphone')
                    ->falseIcon('heroicon-o-minus'),
                TextColumn::make('status')
                    ->label('Statut')
                    ->badge(),
                TextColumn::make('created_at')
                    ->label('Reçu le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Statut')
                    ->options(ContactMessageStatus::class),
            ])
            ->recordActions([
                ViewAction::make(),
                Action::make('valider')
                    ->label('Valider')
                    ->icon('heroicon-o-calendar-days')
                    ->color('success')
                    ->visible(fn (ContactMessage $record) => $record->status === ContactMessageStatus::Nouveau)
                    ->schema([
                        DateTimePicker::make('date_heure')
                            ->label('Date et heure du rendez-vous')
                            ->native(false)
                            ->required(),
                        Textarea::make('notes')
                            ->label('Notes'),
                    ])
                    ->action(function (ContactMessage $record, array $data) {
                        $record->rendezVous()->create([
                            'client_id' => $record->client_id,
                            'date_heure' => $data['date_heure'],
                            'status' => RendezVousStatus::Valide,
                            'notes' => $data['notes'] ?? null,
                        ]);
                        $record->update(['status' => ContactMessageStatus::Traite]);
                    }),
                EditAction::make()
                    ->label('Statut'),
                DeleteAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
