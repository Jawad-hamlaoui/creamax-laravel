<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ClientStatus: string implements HasColor, HasLabel
{
    case Nouveau = 'nouveau';
    case EnContact = 'en_contact';
    case DevisEnvoye = 'devis_envoye';
    case ClientActif = 'client_actif';
    case Inactif = 'inactif';

    public function getLabel(): string
    {
        return match ($this) {
            self::Nouveau => 'Nouveau',
            self::EnContact => 'En contact',
            self::DevisEnvoye => 'Devis envoyé',
            self::ClientActif => 'Client actif',
            self::Inactif => 'Inactif',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Nouveau => 'info',
            self::EnContact => 'warning',
            self::DevisEnvoye => 'purple',
            self::ClientActif => 'success',
            self::Inactif => 'gray',
        };
    }
}
