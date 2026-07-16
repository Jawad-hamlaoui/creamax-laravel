<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\RendezVous;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RendezVousCallAndDirectionsTest extends TestCase
{
    use DatabaseTransactions;

    public function test_view_page_exposes_call_and_directions_links(): void
    {
        $this->actingAs(User::first());

        $client = Client::create([
            'nom' => 'Bertrand', 'prenom' => 'Martin', 'email' => 'martin@test.fr',
            'tel' => '06 12 34 56 78', 'adresse' => '15 Rue des Amandiers, 26000 Valence',
        ]);
        $rendezVous = RendezVous::create(['client_id' => $client->id]);

        $response = $this->get('/admin/rendez-vous/'.$rendezVous->id);

        $response->assertOk();
        $response->assertSee('tel:06 12 34 56 78', false);
        $response->assertSee('https://www.google.com/maps/search/?api=1&amp;query='.urlencode($client->adresse), false);
    }

    public function test_view_page_hides_links_when_client_has_no_phone_or_address(): void
    {
        $this->actingAs(User::first());

        $client = Client::create([
            'nom' => 'Sans', 'prenom' => 'Coordonnées', 'email' => 'sans@test.fr', 'tel' => '',
        ]);
        $rendezVous = RendezVous::create(['client_id' => $client->id]);

        $response = $this->get('/admin/rendez-vous/'.$rendezVous->id);

        $response->assertOk();
        $response->assertDontSee('tel:', false);
        $response->assertDontSee('google.com/maps', false);
    }
}
