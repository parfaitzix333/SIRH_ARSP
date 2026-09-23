<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\annee;
use App\Models\conge;
use App\Models\demandes_conge;
use App\Models\employe;
use App\Models\service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChefServiceCongeTest extends TestCase
{
    use RefreshDatabase;

    public function test_chef_service_sees_and_validates_all_demands_for_the_current_year(): void
    {
        $annee = annee::create([
            'annee' => '2026',
            'statut' => 'active',
        ]);

        $serviceA = service::create([
            'nom_service' => 'Service A',
            'domaine' => 'Informatique',
            'annee_id' => $annee->id,
        ]);

        $serviceB = service::create([
            'nom_service' => 'Service B',
            'domaine' => 'RH',
            'annee_id' => $annee->id,
        ]);

        $chefUser = User::factory()->create(['role' => 'Chef-Service']);
        employe::create([
            'matricule' => 'CHEF-001',
            'nom' => 'Chef Service A',
            'service_id' => $serviceA->id,
            'user_id' => $chefUser->id,
            'annee_id' => $annee->id,
        ]);

        $employeA = employe::create([
            'matricule' => 'EMP-001',
            'nom' => 'Employé A',
            'service_id' => $serviceA->id,
            'annee_id' => $annee->id,
        ]);

        $employeB = employe::create([
            'matricule' => 'EMP-002',
            'nom' => 'Employé B',
            'service_id' => $serviceB->id,
            'annee_id' => $annee->id,
        ]);

        $congeA = conge::create([
            'designation' => 'Congé annuel',
            'TYPE' => 'paye',
            'indice' => '++',
            'actif' => true,
            'annee_id' => $annee->id,
        ]);

        $congeB = conge::create([
            'designation' => 'Congé maladie',
            'TYPE' => 'paye',
            'indice' => '--',
            'actif' => true,
            'annee_id' => $annee->id,
        ]);

        $demandeServiceA = demandes_conge::create([
            'employe_id' => $employeA->id,
            'conge_id' => $congeA->id,
            'date_debut' => '2026-09-20',
            'date_fin' => '2026-09-22',
            'nombre_jour' => 3,
            'motif' => 'Vacances',
            'statut' => 'soumise',
            'annee_id' => $annee->id,
        ]);

        $demandeServiceB = demandes_conge::create([
            'employe_id' => $employeB->id,
            'conge_id' => $congeB->id,
            'date_debut' => '2026-10-01',
            'date_fin' => '2026-10-03',
            'nombre_jour' => 3,
            'motif' => 'Autre service',
            'statut' => 'soumise',
            'annee_id' => $annee->id,
        ]);

        $response = $this->actingAs($chefUser)->get(route('les_demandes_conge_CS'));

        $response->assertOk();
        $response->assertViewHas('les_demandes_conge', function ($demandes) {
            return $demandes->pluck('employe.nom')->sort()->values()->all() === ['Employé A', 'Employé B'];
        });
        $response->assertSee('Employé A');
        $response->assertSee('Employé B');

        $validOtherService = $this->actingAs($chefUser)
            ->put(route('valider_conge', $demandeServiceB->id), ['valide_serv' => true]);

        $validOtherService->assertRedirect();

        $valid = $this->actingAs($chefUser)
            ->put(route('valider_conge', $demandeServiceA->id), ['valide_serv' => true]);

        $valid->assertRedirect();
        $this->assertDatabaseHas('demandes_conges', [
            'id' => $demandeServiceA->id,
            'valide_serv' => true,
        ]);
        $this->assertDatabaseHas('demandes_conges', [
            'id' => $demandeServiceB->id,
            'valide_serv' => true,
        ]);
    }
}
