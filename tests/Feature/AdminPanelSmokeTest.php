<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\ContactMessage;
use App\Models\Devis;
use App\Models\Prestation;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AdminPanelSmokeTest extends TestCase
{
    use DatabaseTransactions;

    public function test_admin_pages_render_for_authenticated_user(): void
    {
        $user = User::first();
        $this->actingAs($user);

        $client = Client::first() ?? Client::create([
            'nom' => 'Smoke', 'prenom' => 'Test', 'email' => 'smoke@test.fr', 'tel' => '0600000000',
        ]);
        $prestation = Prestation::first();
        $devis = Devis::first();
        $contactMessage = ContactMessage::first() ?? ContactMessage::create([
            'prenom' => 'Smoke', 'nom' => 'Test', 'telephone' => '0600000000',
            'email' => 'smoke@test.fr', 'message' => 'Test message',
        ]);

        $urls = [
            '/admin' => 200,
            '/admin/clients' => 200,
            '/admin/clients/create' => 200,
            '/admin/clients/'.$client->id => 200,
            '/admin/clients/'.$client->id.'/edit' => 200,
            '/admin/prestations' => 200,
            '/admin/prestations/create' => 200,
            '/admin/prestations/'.$prestation->id.'/edit' => 200,
            '/admin/devis' => 200,
            '/admin/devis/create' => 200,
            '/admin/contact-messages' => 200,
            '/admin/contact-messages/'.$contactMessage->id => 200,
            '/admin/contact-messages/'.$contactMessage->id.'/edit' => 200,
        ];

        if ($devis) {
            $urls['/admin/devis/'.$devis->id] = 200;
            $urls['/admin/devis/'.$devis->id.'/edit'] = 200;
        }

        foreach ($urls as $url => $expected) {
            $response = $this->get($url);
            if ($response->getStatusCode() !== $expected) {
                file_put_contents(sys_get_temp_dir().'/smoke_fail.html', (string) $response->getContent());
                $this->fail("URL {$url} returned {$response->getStatusCode()} instead of {$expected}. See ".sys_get_temp_dir().'/smoke_fail.html');
            }
        }

        $this->assertTrue(true, count($urls).' pages Filament ont répondu 200.');
    }
}
