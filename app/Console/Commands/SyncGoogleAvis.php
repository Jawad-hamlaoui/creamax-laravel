<?php

namespace App\Console\Commands;

use App\Models\Avis;
use App\Models\Setting;
use App\Services\GooglePlacesService;
use Illuminate\Console\Command;

class SyncGoogleAvis extends Command
{
    protected $signature = 'app:sync-google-avis';

    protected $description = 'Synchronise les avis Google de la fiche établissement (5 derniers, limite de l\'API Places)';

    public function handle(GooglePlacesService $places): int
    {
        $settings = Setting::current();

        $placeId = $places->resolvePlaceId($settings);
        $reviews = $places->fetchReviews($placeId);

        $synced = 0;

        foreach ($reviews as $review) {
            Avis::updateOrCreate(
                ['google_review_id' => $review['name']],
                [
                    'source' => 'google',
                    'nom_client' => $review['authorAttribution']['displayName'] ?? 'Client Google',
                    'auteur_photo_url' => $review['authorAttribution']['photoUri'] ?? null,
                    'note' => $review['rating'] ?? 5,
                    'texte' => $review['text']['text'] ?? '',
                    'date_avis' => $review['publishTime'] ?? null,
                    'actif' => true,
                ]
            );

            $synced++;
        }

        $this->info("{$synced} avis Google synchronisés.");

        return self::SUCCESS;
    }
}
