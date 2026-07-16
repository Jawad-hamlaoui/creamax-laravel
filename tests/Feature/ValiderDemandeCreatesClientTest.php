<?php

namespace Tests\Feature;

use App\Enums\ContactMessageStatus;
use App\Filament\Resources\ContactMessages\Pages\ListContactMessages;
use App\Models\Client;
use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Tests\TestCase;

class ValiderDemandeCreatesClientTest extends TestCase
{
    use DatabaseTransactions;

    public function test_validating_a_request_creates_a_client_with_its_information(): void
    {
        $this->actingAs(User::first());

        $demande = ContactMessage::create([
            'prenom' => 'Sophie', 'nom' => 'Durand', 'telephone' => '06 11 22 33 44',
            'email' => 'sophie.durand@test.fr', 'commune' => 'Valence', 'prestation' => 'Entretien jardin',
            'message' => 'Bonjour, je souhaite un devis.',
        ]);

        Livewire::test(ListContactMessages::class)
            ->callTableAction('valider', $demande, data: [
                'date_heure' => now()->addDays(3)->format('Y-m-d H:i:s'),
                'notes' => 'Visite terrain',
            ])
            ->assertHasNoTableActionErrors();

        $client = Client::where('email', 'sophie.durand@test.fr')->first();

        $this->assertNotNull($client, 'Le client aurait dû être créé.');
        $this->assertSame('Sophie', $client->prenom);
        $this->assertSame('Durand', $client->nom);
        $this->assertSame('06 11 22 33 44', $client->tel);
        $this->assertSame('Valence', $client->adresse);
        $this->assertSame('Entretien jardin', $client->prestation);

        $demande->refresh();
        $this->assertSame($client->id, $demande->client_id);
        $this->assertTrue($demande->status === ContactMessageStatus::Traite);

        $rendezVous = $client->rendezVous()->first();
        $this->assertNotNull($rendezVous, 'Le rendez-vous aurait dû être créé et lié au client.');
    }

    public function test_validating_a_request_reuses_an_existing_client_with_the_same_email(): void
    {
        $this->actingAs(User::first());

        $existingClient = Client::create([
            'nom' => 'Durand', 'prenom' => 'Sophie', 'email' => 'sophie.durand@test.fr', 'tel' => '0600000000',
        ]);

        $demande = ContactMessage::create([
            'prenom' => 'Sophie', 'nom' => 'Durand', 'telephone' => '06 11 22 33 44',
            'email' => 'sophie.durand@test.fr', 'message' => 'Bonjour.',
        ]);

        Livewire::test(ListContactMessages::class)
            ->callTableAction('valider', $demande, data: [
                'date_heure' => now()->addDays(3)->format('Y-m-d H:i:s'),
            ])
            ->assertHasNoTableActionErrors();

        $this->assertSame(1, Client::where('email', 'sophie.durand@test.fr')->count());

        $demande->refresh();
        $this->assertSame($existingClient->id, $demande->client_id);
    }
}
