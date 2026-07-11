<?php

namespace App\Models;

use App\Enums\ContactMessageStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactMessage extends Model
{
    const PRESTATIONS = [
        'Création de jardin' => 'Création de jardin',
        'Aménagement extérieur' => 'Aménagement extérieur',
        'Entretien régulier' => 'Entretien régulier',
        'Élagage / Abattage' => 'Élagage / Abattage',
        'Arrosage automatique' => 'Arrosage automatique',
        'Espaces pros' => 'Espaces pros',
        'Autre' => 'Autre',
    ];

    protected $guarded = ['id'];

    protected $attributes = [
        'status' => 'nouveau',
    ];

    protected $casts = [
        'status' => ContactMessageStatus::class,
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
