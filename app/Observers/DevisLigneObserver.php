<?php

namespace App\Observers;

use App\Models\DevisLigne;

class DevisLigneObserver
{
    public function saved(DevisLigne $ligne): void
    {
        $ligne->devis?->recalculateTotals();
    }

    public function deleted(DevisLigne $ligne): void
    {
        $ligne->devis?->recalculateTotals();
    }
}
