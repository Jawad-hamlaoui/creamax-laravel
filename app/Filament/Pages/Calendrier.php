<?php

namespace App\Filament\Pages;

use App\Models\RendezVous;
use App\Models\Setting;
use BackedEnum;
use Carbon\CarbonImmutable;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\URL as UrlGenerator;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;

class Calendrier extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static ?string $navigationLabel = 'Calendrier';

    protected static ?int $navigationSort = 4;

    protected static ?string $title = 'Calendrier';

    protected string $view = 'filament.pages.calendrier';

    #[Url]
    public string $mois;

    public function mount(): void
    {
        $this->mois ??= now()->format('Y-m');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('lienIphone')
                ->label('Lien iPhone')
                ->icon('heroicon-o-link')
                ->color('gray')
                ->modalHeading('Lien d\'abonnement iPhone')
                ->modalSubmitAction(false)
                ->modalCancelActionLabel('Fermer')
                ->schema([
                    TextInput::make('feed_url')
                        ->label('Lien d\'abonnement')
                        ->helperText('Sur ton iPhone : Réglages > Calendrier > Comptes > Ajouter un compte > Autre > Ajouter un calendrier avec abonnement, puis colle ce lien. Seuls les rendez-vous validés apparaissent, et l\'iPhone les met à jour toutes les heures environ.')
                        ->readOnly()
                        ->copyable()
                        ->default(fn () => $this->getFeedUrl()),
                ]),
            Action::make('regenerateFeed')
                ->label('Régénérer le lien iPhone')
                ->icon('heroicon-o-arrow-path')
                ->color('danger')
                ->requiresConfirmation()
                ->modalDescription('L\'ancien lien cessera de fonctionner immédiatement. Il faudra ré-ajouter le nouveau lien sur ton iPhone.')
                ->action(function () {
                    Setting::current()->regenerateCalendarToken();

                    Notification::make()
                        ->title('Lien régénéré')
                        ->success()
                        ->send();
                }),
        ];
    }

    protected function getFeedUrl(): string
    {
        $url = UrlGenerator::route('calendrier.feed', ['token' => Setting::current()->calendarToken()]);

        return preg_replace('/^https?:\/\//', 'webcal://', $url);
    }

    public function previousMonth(): void
    {
        $this->mois = $this->currentMonth()->subMonthNoOverflow()->format('Y-m');
    }

    public function nextMonth(): void
    {
        $this->mois = $this->currentMonth()->addMonthNoOverflow()->format('Y-m');
    }

    public function aujourdhui(): void
    {
        $this->mois = now()->format('Y-m');
    }

    protected function currentMonth(): CarbonImmutable
    {
        return CarbonImmutable::createFromFormat('Y-m-d', $this->mois.'-01');
    }

    #[Computed]
    public function monthLabel(): string
    {
        return ucfirst($this->currentMonth()->locale('fr')->isoFormat('MMMM YYYY'));
    }

    /**
     * @return Collection<int, array{date: CarbonImmutable, inMonth: bool, isToday: bool, rendezVous: Collection}>
     */
    #[Computed]
    public function weeks(): Collection
    {
        $month = $this->currentMonth();
        $startOfGrid = $month->startOfMonth()->startOfWeek(CarbonImmutable::MONDAY);
        $endOfGrid = $month->endOfMonth()->endOfWeek(CarbonImmutable::SUNDAY);

        $rendezVousParJour = RendezVous::query()
            ->whereNotNull('date_heure')
            ->whereBetween('date_heure', [$startOfGrid->startOfDay(), $endOfGrid->endOfDay()])
            ->with('client')
            ->orderBy('date_heure')
            ->get()
            ->groupBy(fn (RendezVous $rendezVous) => $rendezVous->date_heure->format('Y-m-d'));

        $today = now()->format('Y-m-d');
        $days = collect();
        $cursor = $startOfGrid;

        while ($cursor->lte($endOfGrid)) {
            $days->push([
                'date' => $cursor,
                'inMonth' => $cursor->format('Y-m') === $this->mois,
                'isToday' => $cursor->format('Y-m-d') === $today,
                'rendezVous' => $rendezVousParJour->get($cursor->format('Y-m-d'), collect()),
            ]);

            $cursor = $cursor->addDay();
        }

        return $days->chunk(7)->values();
    }
}
