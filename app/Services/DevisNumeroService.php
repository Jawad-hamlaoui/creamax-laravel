<?php

namespace App\Services;

use App\Models\Devis;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DevisNumeroService
{
    /**
     * Alloue de façon sûre (verrou + transaction) le prochain numéro de devis
     * pour l'année en cours, au format DEV-{année}-{séquence sur 3 chiffres}.
     */
    public function next(): array
    {
        return Cache::lock('devis-numero-generation', 10)->block(5, function () {
            return DB::transaction(function () {
                $year = (int) now()->year;
                $lastSeq = Devis::where('annee', $year)->lockForUpdate()->max('sequence') ?? 0;
                $seq = $lastSeq + 1;

                return [
                    'annee' => $year,
                    'sequence' => $seq,
                    'numero' => sprintf('DEV-%d-%03d', $year, $seq),
                ];
            });
        });
    }
}
