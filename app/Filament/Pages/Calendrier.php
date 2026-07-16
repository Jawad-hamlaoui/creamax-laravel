<?php

namespace App\Filament\Pages;

use App\Models\RendezVous;
use BackedEnum;
use Carbon\CarbonImmutable;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;

class Calendrier extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static ?string $navigationLabel = 'Calendrier';

    protected static ?string $title = 'Calendrier';

    protected string $view = 'filament.pages.calendrier';

    #[Url]
    public string $mois;

    public function mount(): void
    {
        $this->mois ??= now()->format('Y-m');
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
