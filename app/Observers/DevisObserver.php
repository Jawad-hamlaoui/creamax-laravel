<?php

namespace App\Observers;

use App\Models\Devis;
use App\Models\Setting;
use App\Services\DevisNumeroService;

class DevisObserver
{
    public function creating(Devis $devis): void
    {
        if (empty($devis->numero)) {
            $numero = app(DevisNumeroService::class)->next();
            $devis->annee = $numero['annee'];
            $devis->sequence = $numero['sequence'];
            $devis->numero = $numero['numero'];
        }

        if (empty($devis->date_creation)) {
            $devis->date_creation = now()->toDateString();
        }

        if (empty($devis->tva_taux)) {
            $devis->tva_taux = Setting::current()->taux_tva;
        }
    }
}
