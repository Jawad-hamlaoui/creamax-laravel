<?php

namespace App\Models;

use App\Enums\RendezVousStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RendezVous extends Model
{
    protected $table = 'rendez_vous';

    protected $guarded = ['id'];

    protected $attributes = [
        'status' => 'en_attente',
    ];

    protected $casts = [
        'status' => RendezVousStatus::class,
        'date_heure' => 'datetime',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function contactMessage(): BelongsTo
    {
        return $this->belongsTo(ContactMessage::class);
    }
}
