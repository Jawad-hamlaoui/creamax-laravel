<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PrestationUnite: string implements HasLabel
{
    case Heure = 'heure';
    case M2 = 'm2';
    case Forfait = 'forfait';
    case Jour = 'jour';

    public function getLabel(): string
    {
        return match ($this) {
            self::Heure => 'heure',
            self::M2 => 'm²',
            self::Forfait => 'forfait',
            self::Jour => 'jour',
        };
    }
}
