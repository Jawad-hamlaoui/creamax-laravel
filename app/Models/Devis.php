<?php

namespace App\Models;

use App\Enums\DevisStatus;
use App\Observers\DevisObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy(DevisObserver::class)]
class Devis extends Model
{
    use HasFactory;

    protected $table = 'devis';

    protected $guarded = ['id'];

    protected $attributes = [
        'status' => 'brouillon',
        'validite_jours' => 30,
    ];

    protected $casts = [
        'status' => DevisStatus::class,
        'date_creation' => 'date',
        'sous_total' => 'decimal:2',
        'tva_taux' => 'decimal:2',
        'tva_montant' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function lignes(): HasMany
    {
        return $this->hasMany(DevisLigne::class)->orderBy('ordre');
    }

    /**
     * Recalcule sous_total/tva_montant/total à partir des lignes actuelles.
     * Appelé par DevisLigneObserver à chaque création/modification/suppression de ligne.
     */
    public function recalculateTotals(): void
    {
        $sousTotal = round($this->lignes()->get()->sum(fn (DevisLigne $ligne) => $ligne->total), 2);
        $tvaTaux = $this->tva_taux ?? Setting::current()->taux_tva;
        $tvaMontant = round($sousTotal * (float) $tvaTaux / 100, 2);
        $total = $sousTotal + $tvaMontant;

        $this->forceFill([
            'sous_total' => number_format($sousTotal, 2, '.', ''),
            'tva_montant' => number_format($tvaMontant, 2, '.', ''),
            'total' => number_format($total, 2, '.', ''),
        ])->saveQuietly();
    }
}
