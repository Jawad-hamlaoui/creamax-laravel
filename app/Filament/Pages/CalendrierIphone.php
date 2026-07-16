<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\URL;

class CalendrierIphone extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static ?string $navigationLabel = 'Calendrier iPhone';

    protected static ?string $title = 'Calendrier iPhone';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'feed_url' => $this->getFeedUrl(),
        ]);
    }

    protected function getFeedUrl(): string
    {
        $url = URL::route('calendrier.feed', ['token' => Setting::current()->calendarToken()]);

        return preg_replace('/^https?:\/\//', 'webcal://', $url);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('feed_url')
                    ->label('Lien d\'abonnement')
                    ->helperText('Sur ton iPhone : Réglages > Calendrier > Comptes > Ajouter un compte > Autre > Ajouter un calendrier avec abonnement, puis colle ce lien. Seuls les rendez-vous validés apparaissent, et l\'iPhone les met à jour toutes les heures environ.')
                    ->readOnly()
                    ->copyable(),
            ])
            ->statePath('data');
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                Form::make([EmbeddedSchema::make('form')])
                    ->id('form')
                    ->livewireSubmitHandler('regenerate')
                    ->footer([
                        Actions::make([
                            Action::make('regenerate')
                                ->label('Régénérer le lien')
                                ->color('danger')
                                ->requiresConfirmation()
                                ->modalDescription('L\'ancien lien cessera de fonctionner immédiatement. Il faudra ré-ajouter le nouveau lien sur ton iPhone.')
                                ->submit('regenerate'),
                        ]),
                    ]),
            ]);
    }

    public function regenerate(): void
    {
        Setting::current()->regenerateCalendarToken();

        $this->form->fill([
            'feed_url' => $this->getFeedUrl(),
        ]);

        Notification::make()
            ->title('Lien régénéré')
            ->success()
            ->send();
    }
}
