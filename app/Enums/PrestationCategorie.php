<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum PrestationCategorie: string implements HasColor, HasLabel
{
    case Creation = 'creation';
    case Entretien = 'entretien';
    case Amenagement = 'amenagement';

    public function getLabel(): string
    {
        return match ($this) {
            self::Creation => 'Création',
            self::Entretien => 'Entretien',
            self::Amenagement => 'Aménagement',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Creation => 'success',
            self::Entretien => 'info',
            self::Amenagement => 'purple',
        };
    }
}
