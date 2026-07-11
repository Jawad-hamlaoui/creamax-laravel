<?php

namespace App\Models;

use App\Observers\DevisLigneObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy(DevisLigneObserver::class)]
class DevisLigne extends Model
{
    protected $table = 'devis_lignes';

    protected $guarded = ['id'];

    protected $casts = [
        'quantite' => 'decimal:2',
        'prix_unitaire' => 'decimal:2',
    ];

    public function devis(): BelongsTo
    {
        return $this->belongsTo(Devis::class);
    }

    public function prestation(): BelongsTo
    {
        return $this->belongsTo(Prestation::class);
    }

    public function getTotalAttribute(): float
    {
        return round((float) $this->quantite * (float) $this->prix_unitaire, 2);
    }
}
