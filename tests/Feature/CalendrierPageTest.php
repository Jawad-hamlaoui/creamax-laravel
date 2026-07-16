<?php

namespace Tests\Feature;

use App\Enums\RendezVousStatus;
use App\Filament\Pages\Calendrier;
use App\Models\Client;
use App\Models\RendezVous;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Tests\TestCase;

class CalendrierPageTest extends TestCase
{
    use DatabaseTransactions;

    public function test_calendar_shows_rendez_vous_for_the_current_month_and_navigates(): void
    {
        $this->actingAs(User::first());

        $client = Client::create([
            'nom' => 'Calendrier', 'prenom' => 'Test', 'email' => 'calendrier@test.fr', 'tel' => '0600000000',
        ]);

        $rendezVous = RendezVous::create([
            'client_id' => $client->id,
            'date_heure' => now()->startOfMonth()->addDays(5)->setTime(10, 0),
            'status' => RendezVousStatus::Valide,
        ]);

        Livewire::test(Calendrier::class)
            ->assertSee($client->prenom)
            ->call('nextMonth')
            ->assertDontSee($client->prenom)
            ->call('previousMonth')
            ->assertSee($client->prenom)
            ->call('aujourdhui')
            ->assertSee($client->prenom);
    }

    public function test_iphone_link_and_regenerate_actions_are_available_on_the_calendar_page(): void
    {
        $this->actingAs(User::first());

        $oldToken = Setting::current()->calendarToken();

        Livewire::test(Calendrier::class)
            ->assertActionExists('lienIphone')
            ->assertActionExists('regenerateFeed')
            ->callAction('regenerateFeed')
            ->assertHasNoActionErrors();

        $this->assertNotSame($oldToken, Setting::current()->fresh()->calendar_token);
    }
}
