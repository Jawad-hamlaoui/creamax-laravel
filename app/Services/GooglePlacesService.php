<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class GooglePlacesService
{
    private const BASE_URL = 'https://places.googleapis.com/v1';

    public function __construct(
        private readonly ?string $apiKey = null,
    ) {
    }

    private function apiKey(): string
    {
        $key = $this->apiKey ?? config('services.google_places.key');

        if (blank($key)) {
            throw new RuntimeException('GOOGLE_PLACES_API_KEY manquante.');
        }

        return $key;
    }

    /**
     * Retrouve le Place ID de l'établissement à partir de son nom et de son
     * adresse, et le met en cache sur le modèle Setting pour éviter de le
     * rechercher à chaque synchronisation.
     */
    public function resolvePlaceId(Setting $settings): string
    {
        if (filled($settings->google_place_id)) {
            return $settings->google_place_id;
        }

        $response = Http::withHeaders([
            'X-Goog-Api-Key' => $this->apiKey(),
            'X-Goog-FieldMask' => 'places.id,places.displayName,places.formattedAddress',
        ])->post(self::BASE_URL.'/places:searchText', [
            'textQuery' => "{$settings->nom_entreprise}, {$settings->adresse}",
            'locationBias' => [
                'circle' => [
                    'center' => ['latitude' => 44.6983142, 'longitude' => 4.662234],
                    'radius' => 5000.0,
                ],
            ],
        ]);

        $response->throw();

        $placeId = $response->json('places.0.id');

        if (blank($placeId)) {
            throw new RuntimeException('Aucun établissement Google Places trouvé pour ce nom/cette adresse.');
        }

        $settings->update(['google_place_id' => $placeId]);

        return $placeId;
    }

    /**
     * Récupère les avis de la fiche Google (5 maximum, limite imposée par
     * l'API Places, non configurable).
     */
    public function fetchReviews(string $placeId): array
    {
        $response = Http::withHeaders([
            'X-Goog-Api-Key' => $this->apiKey(),
            'X-Goog-FieldMask' => 'reviews',
        ])->get(self::BASE_URL."/places/{$placeId}");

        $response->throw();

        return $response->json('reviews', []);
    }
}
