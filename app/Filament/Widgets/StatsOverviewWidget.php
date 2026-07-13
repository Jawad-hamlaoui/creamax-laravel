<?php

namespace App\Filament\Widgets;

use App\Enums\DevisStatus;
use App\Models\Client;
use App\Models\Devis;
use Filament\Widgets\StatsOverviewWidget as BaseStatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseStatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Clients au total', Client::count())
                ->icon('heroicon-o-users')
                ->color('success'),
            Stat::make('Devis au total', Devis::count())
                ->icon('heroicon-o-document-text')
                ->color('info'),
            Stat::make('Devis en cours', Devis::whereIn('status', [DevisStatus::Brouillon, DevisStatus::Envoye])->count())
                ->icon('heroicon-o-clock')
                ->color('warning'),
            Stat::make('CA accepté', number_format((float) Devis::where('status', DevisStatus::Accepte)->sum('total'), 2, ',', ' ').' €')
                ->icon('heroicon-o-banknotes')
                ->color('purple'),
        ];
    }
}
