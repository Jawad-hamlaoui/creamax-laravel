<?php

namespace App\Console\Commands;

use App\Services\GooglePlacesService;
use Illuminate\Console\Command;

class SyncGoogleAvis extends Command
{
    protected $signature = 'app:sync-google-avis';

    protected $description = 'Synchronise les avis Google de la fiche établissement (5 derniers, limite de l\'API Places)';

    public function handle(GooglePlacesService $places): int
    {
        $synced = $places->syncReviews();

        $this->info("{$synced} avis Google synchronisés.");

        return self::SUCCESS;
    }
}
