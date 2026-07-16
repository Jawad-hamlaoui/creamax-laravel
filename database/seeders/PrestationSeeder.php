<?php

namespace Database\Seeders;

use App\Enums\PrestationCategorie;
use App\Models\Prestation;
use Illuminate\Database\Seeder;

class PrestationSeeder extends Seeder
{
    /**
     * Catalogue de départ, à ajuster par l'administrateur depuis le back-office.
     */
    public function run(): void
    {
        $prestations = [
            [
                'titre' => 'Création de jardin',
                'categorie' => PrestationCategorie::Creation,
                'description' => 'Conception et réalisation complète d\'un jardin : plantations, engazonnement, allées.',
            ],
            [
                'titre' => 'Aménagement paysager',
                'categorie' => PrestationCategorie::Amenagement,
                'description' => 'Terrasses, massifs, clôtures végétales et petits ouvrages extérieurs.',
            ],
            [
                'titre' => 'Entretien de jardin',
                'categorie' => PrestationCategorie::Entretien,
                'description' => 'Tonte, désherbage, taille légère et entretien régulier des espaces verts.',
            ],
            [
                'titre' => 'Taille de haies et arbustes',
                'categorie' => PrestationCategorie::Entretien,
                'description' => 'Taille, mise en forme et évacuation des déchets verts.',
            ],
            [
                'titre' => 'Engazonnement',
                'categorie' => PrestationCategorie::Creation,
                'description' => 'Préparation du sol et engazonnement (semis ou placage de gazon).',
            ],
            [
                'titre' => 'Arrosage automatique',
                'categorie' => PrestationCategorie::Amenagement,
                'description' => 'Étude, installation et mise en service d\'un système d\'arrosage automatique.',
            ],
        ];

        foreach ($prestations as $prestation) {
            Prestation::query()->firstOrCreate(['titre' => $prestation['titre']], $prestation);
        }
    }
}
