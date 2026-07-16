<x-filament-panels::page>
    <style>
        .cm-cal-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 16px; flex-wrap: wrap; gap: 12px;
        }
        .cm-cal-title {
            font-family: 'Playfair Display', ui-serif, serif;
            font-weight: 700; font-size: 20px; color: var(--cm-vert, #234625);
            text-transform: capitalize;
        }
        .cm-cal-nav { display: flex; align-items: center; gap: 6px; }
        .cm-cal-grid {
            display: grid; grid-template-columns: repeat(7, 1fr);
            border: 1px solid var(--cm-bord, #e4e2d8);
            border-radius: 12px; overflow: hidden;
        }
        .cm-cal-weekday {
            padding: 8px 6px; font-size: 11px; font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.04em;
            color: var(--cm-texte-fin, #7a7a6a); text-align: center;
            background: var(--cm-creme, #fcfbf7);
            border-bottom: 1px solid var(--cm-bord, #e4e2d8);
        }
        .cm-cal-day {
            min-height: 96px; padding: 6px; border-right: 1px solid var(--cm-bord, #e4e2d8);
            border-bottom: 1px solid var(--cm-bord, #e4e2d8);
            display: flex; flex-direction: column; gap: 4px;
        }
        .cm-cal-day:nth-child(7n) { border-right: none; }
        .cm-cal-day.cm-out { background: var(--cm-creme, #fcfbf7); opacity: 0.55; }
        .cm-cal-day-num {
            font-size: 12px; font-weight: 600; color: var(--cm-texte, #1a1a14);
            width: 22px; height: 22px; display: flex; align-items: center; justify-content: center;
            border-radius: 9999px;
        }
        .cm-cal-day.cm-today .cm-cal-day-num { background: var(--cm-vert, #234625); color: #fff; }
        .cm-cal-rdv {
            display: block; font-size: 11px; line-height: 1.3; padding: 2px 5px;
            border-radius: 6px; color: #fff; text-decoration: none;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .cm-cal-rdv:hover { filter: brightness(0.92); }
        .cm-cal-rdv.status-valide { background: #3a7a3c; }
        .cm-cal-rdv.status-en_attente { background: #c58b1f; }
        .cm-cal-rdv.status-refuse { background: #b91c1c; }
        .cm-cal-legend { display: flex; gap: 16px; margin-top: 14px; font-size: 12px; color: var(--cm-texte-fin, #7a7a6a); }
        .cm-cal-legend-dot { display: inline-block; width: 8px; height: 8px; border-radius: 9999px; margin-right: 5px; }
    </style>

    <div class="cm-cal-header">
        <div class="cm-cal-title">{{ $this->monthLabel }}</div>
        <div class="cm-cal-nav">
            <x-filament::icon-button icon="heroicon-o-chevron-left" wire:click="previousMonth" label="Mois précédent" />
            <x-filament::button color="gray" wire:click="aujourdhui">Aujourd'hui</x-filament::button>
            <x-filament::icon-button icon="heroicon-o-chevron-right" wire:click="nextMonth" label="Mois suivant" />
        </div>
    </div>

    <div class="cm-cal-grid">
        @foreach (['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'] as $jour)
            <div class="cm-cal-weekday">{{ $jour }}</div>
        @endforeach

        @foreach ($this->weeks as $semaine)
            @foreach ($semaine as $jour)
                <div class="cm-cal-day {{ $jour['inMonth'] ? '' : 'cm-out' }} {{ $jour['isToday'] ? 'cm-today' : '' }}">
                    <div class="cm-cal-day-num">{{ $jour['date']->day }}</div>
                    @foreach ($jour['rendezVous'] as $rdv)
                        <a
                            href="{{ \App\Filament\Resources\RendezVous\RendezVousResource::getUrl('view', ['record' => $rdv]) }}"
                            class="cm-cal-rdv status-{{ $rdv->status->value }}"
                            title="{{ $rdv->date_heure->format('H:i') }} — {{ $rdv->client ? "{$rdv->client->prenom} {$rdv->client->nom}" : 'Client non renseigné' }} ({{ $rdv->status->getLabel() }})"
                        >
                            {{ $rdv->date_heure->format('H:i') }} {{ $rdv->client?->prenom }} {{ $rdv->client?->nom }}
                        </a>
                    @endforeach
                </div>
            @endforeach
        @endforeach
    </div>

    <div class="cm-cal-legend">
        <span><span class="cm-cal-legend-dot" style="background:#3a7a3c;"></span>Validé</span>
        <span><span class="cm-cal-legend-dot" style="background:#c58b1f;"></span>En attente</span>
        <span><span class="cm-cal-legend-dot" style="background:#b91c1c;"></span>Refusé</span>
    </div>
</x-filament-panels::page>
