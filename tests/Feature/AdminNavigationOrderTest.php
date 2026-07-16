<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AdminNavigationOrderTest extends TestCase
{
    use DatabaseTransactions;

    public function test_navigation_items_appear_in_the_requested_order(): void
    {
        $this->actingAs(User::first());

        $content = $this->get('/admin')->getContent();

        $expectedOrder = [
            'Nouvelle demande de rendez-vous',
            'Rendez-vous validé',
            'Devis',
            'Calendrier',
            'Clients',
            'Prestations',
            'Images du site',
            'Réalisations',
        ];

        $positions = [];

        foreach ($expectedOrder as $label) {
            $position = mb_strpos($content, $label);
            $this->assertNotFalse($position, "Le libellé de navigation \"{$label}\" est introuvable dans le menu.");
            $positions[$label] = $position;
        }

        $sorted = $positions;
        asort($sorted);

        $this->assertSame(
            $expectedOrder,
            array_keys($sorted),
            'Les éléments du menu ne sont pas dans l\'ordre attendu.'
        );
    }
}
