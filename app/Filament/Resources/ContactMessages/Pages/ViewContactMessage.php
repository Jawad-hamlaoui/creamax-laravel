<?php

namespace App\Filament\Resources\ContactMessages\Pages;

use App\Enums\ContactMessageStatus;
use App\Filament\Resources\Clients\Schemas\ClientForm;
use App\Filament\Resources\ContactMessages\ContactMessageResource;
use App\Models\Client;
use App\Models\ContactMessage;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ViewContactMessage extends ViewRecord
{
    protected static string $resource = ContactMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('convertToClient')
                ->label('Convertir en client')
                ->icon('heroicon-o-user-plus')
                ->color('success')
                ->visible(fn (ContactMessage $record) => $record->client_id === null)
                ->schema([
                    TextInput::make('prenom')->label('Prénom')->required(),
                    TextInput::make('nom')->label('Nom')->required(),
                    TextInput::make('email')->label('Email')->email()->required(),
                    TextInput::make('tel')->label('Téléphone')->tel()->required(),
                    TextInput::make('adresse')->label('Adresse'),
                    Select::make('prestation')
                        ->label('Prestation souhaitée')
                        ->options(ClientForm::PRESTATIONS_SOUHAITEES),
                ])
                ->fillForm(fn (ContactMessage $record) => [
                    'prenom' => $record->prenom,
                    'nom' => $record->nom,
                    'email' => $record->email,
                    'tel' => $record->telephone,
                    'adresse' => $record->commune,
                    'prestation' => $record->prestation,
                ])
                ->action(function (ContactMessage $record, array $data) {
                    $client = Client::create($data);
                    $record->update(['client_id' => $client->id, 'status' => ContactMessageStatus::Traite]);

                    Notification::make()
                        ->title('Client créé')
                        ->success()
                        ->send();
                }),
            EditAction::make()->label('Statut'),
        ];
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns(2)
                    ->components([
                        TextEntry::make('prenom')->label('Prénom'),
                        TextEntry::make('nom')->label('Nom'),
                        TextEntry::make('email')->label('Email'),
                        TextEntry::make('telephone')->label('Téléphone'),
                        TextEntry::make('commune')->label('Commune')->placeholder('—'),
                        TextEntry::make('prestation')->label('Prestation')->placeholder('—'),
                        TextEntry::make('status')->label('Statut')->badge(),
                        TextEntry::make('created_at')->label('Reçu le')->dateTime('d/m/Y H:i'),
                        TextEntry::make('message')->label('Message')->columnSpanFull(),
                    ]),
                Section::make('Message vocal')
                    ->visible(fn (ContactMessage $record) => filled($record->audio_path))
                    ->components([
                        ViewEntry::make('audio_path')
                            ->label('')
                            ->view('filament.infolists.audio-player'),
                    ]),
            ]);
    }
}
