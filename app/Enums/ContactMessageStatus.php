<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ContactMessageStatus: string implements HasColor, HasLabel
{
    case Nouveau = 'nouveau';
    case Traite = 'traite';

    public function getLabel(): string
    {
        return match ($this) {
            self::Nouveau => 'Nouveau',
            self::Traite => 'Traité',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Nouveau => 'info',
            self::Traite => 'success',
        };
    }
}
