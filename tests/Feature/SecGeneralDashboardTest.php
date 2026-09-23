<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SecGeneralDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_sec_general_without_authorisation_cannot_open_dashboard(): void
    {
        $user = User::factory()->create([
            'role' => 'SecDG',
            'autorisation' => false,
        ]);

        $this->actingAs($user)
            ->get(route('accueil_secDg'))
            ->assertForbidden();
    }

    public function test_authorised_sec_general_can_open_dashboard(): void
    {
        $user = User::factory()->create([
            'role' => 'SecDG',
            'autorisation' => true,
        ]);

        $this->actingAs($user)
            ->get(route('accueil_secDg'))
            ->assertOk()
            ->assertSee('Tableau de bord Secrétaire général');
    }
}
