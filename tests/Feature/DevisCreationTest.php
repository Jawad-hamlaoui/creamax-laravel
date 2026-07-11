<?php

namespace Tests\Feature;

use App\Filament\Resources\Devis\Pages\CreateDevis;
use App\Models\Client;
use App\Models\Devis;
use App\Models\Prestation;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Tests\TestCase;

class DevisCreationTest extends TestCase
{
    use DatabaseTransactions;

    public function test_devis_can_be_created_with_lines_through_the_admin_form(): void
    {
        $this->actingAs(User::first());

        $client = Client::create([
            'nom' => 'Livewire', 'prenom' => 'Test', 'email' => 'livewire-test@example.com', 'tel' => '0600000000',
        ]);
        $prestation = Prestation::first();

        Livewire::test(CreateDevis::class)
            ->fillForm([
                'client_id' => $client->id,
                'lignes' => [
                    ['prestation_id' => $prestation->id, 'description' => $prestation->titre, 'quantite' => 2, 'prix_unitaire' => (string) $prestation->prix],
                    ['description' => 'Ligne libre', 'quantite' => 1, 'prix_unitaire' => 50],
                ],
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $devis = Devis::where('client_id', $client->id)->latest('id')->first();

        $this->assertNotNull($devis, 'Le devis devrait avoir été créé.');
        $this->assertMatchesRegularExpression('/^DEV-\d{4}-\d{3}$/', $devis->numero);
        $this->assertCount(2, $devis->lignes);

        $expectedSousTotal = ((float) $prestation->prix * 2) + 50;
        $this->assertEqualsWithDelta($expectedSousTotal, (float) $devis->sous_total, 0.01);
        $this->assertEqualsWithDelta($expectedSousTotal * 1.20, (float) $devis->total, 0.01);
    }
}
