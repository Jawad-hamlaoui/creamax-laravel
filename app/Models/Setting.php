<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Setting extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'taux_tva' => 'decimal:2',
    ];

    public static function current(): self
    {
        return Cache::rememberForever('settings', fn () => static::query()->firstOrCreate(['id' => 1], [
            'nom_entreprise' => "Créa'Max Paysage",
            'dirigeant' => 'Maxime Maazaoui',
            'forme_juridique' => 'EI',
            'adresse' => '3 Lotissement Carabas, 07350 Cruas',
            'siren' => '101698926',
            'siret' => '10169892600017',
            'tva_intra' => 'FR71101698926',
            'ape' => '8130Z',
            'zone_intervention' => 'Drôme (26) / Ardèche (07)',
            'taux_tva' => '20.00',
            'cgv_texte' => Setting::defaultCgvTexte(),
            'calendar_token' => Str::random(40),
        ]));
    }

    public function calendarToken(): string
    {
        if (blank($this->calendar_token)) {
            $this->regenerateCalendarToken();
        }

        return $this->calendar_token;
    }

    public function regenerateCalendarToken(): string
    {
        $this->calendar_token = Str::random(40);
        $this->save();

        return $this->calendar_token;
    }

    public static function defaultCgvTexte(): string
    {
        return "Devis valable pour la durée indiquée à compter de sa date d'émission. "
            .'Un acompte de 30% du montant total TTC est demandé à la signature du devis, le solde étant '
            .'exigible à la livraison des travaux. Tout retard de paiement entraînera des pénalités calculées '
            .'au taux de 3 fois le taux d\'intérêt légal, ainsi qu\'une indemnité forfaitaire de 40€ pour '
            .'frais de recouvrement (article L441-10 du Code de commerce).';
    }

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('settings'));
    }
}
