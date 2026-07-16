<?php

namespace Tests\Feature;

use App\Enums\RendezVousStatus;
use App\Models\Client;
use App\Models\RendezVous;
use App\Models\Setting;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CalendarFeedTest extends TestCase
{
    use DatabaseTransactions;

    public function test_feed_rejects_wrong_token(): void
    {
        Setting::current()->calendarToken();

        $response = $this->get('/calendrier/token-invalide.ics');

        $response->assertNotFound();
    }

    public function test_feed_returns_only_validated_rendez_vous(): void
    {
        $token = Setting::current()->calendarToken();
        $client = Client::create([
            'nom' => 'Feed', 'prenom' => 'Test', 'email' => 'feed@test.fr', 'tel' => '0600000000',
        ]);

        $valide = RendezVous::create([
            'client_id' => $client->id,
            'date_heure' => now()->addDay(),
            'status' => RendezVousStatus::Valide,
        ]);
        $enAttente = RendezVous::create([
            'client_id' => $client->id,
            'date_heure' => now()->addDays(2),
            'status' => RendezVousStatus::EnAttente,
        ]);

        $response = $this->get('/calendrier/'.$token.'.ics');

        $response->assertOk();
        $response->assertHeader('Content-Type', 'text/calendar; charset=utf-8');
        $content = $response->getContent();

        $this->assertStringContainsString('BEGIN:VCALENDAR', $content);
        $this->assertStringContainsString('UID:rendez-vous-'.$valide->id.'@', $content);
        $this->assertStringNotContainsString('UID:rendez-vous-'.$enAttente->id.'@', $content);
    }

    public function test_regenerating_token_invalidates_the_old_link(): void
    {
        $oldToken = Setting::current()->calendarToken();

        Setting::current()->regenerateCalendarToken();

        $this->get('/calendrier/'.$oldToken.'.ics')->assertNotFound();
        $this->get('/calendrier/'.Setting::current()->calendarToken().'.ics')->assertOk();
    }
}
