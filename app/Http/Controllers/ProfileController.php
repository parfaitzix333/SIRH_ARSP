<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\affectation;
use App\Models\annee;
use App\Models\demandes_conge;
use App\Models\employe;
use App\Models\presence;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
    private function var_dashboard()
    {
        $annee_courant = annee::where('statut', 'active')->first();
        $anneeId = $annee_courant?->id;
        $annee = $annee_courant?->annee ?? now()->year;
        $demandes = demandes_conge::query()
            ->whereYear('date_debut', $annee);
        $demandesNonValidees = (clone $demandes)
            ->with(['employe', 'conge'])
            ->where(function ($query) {
                $query->whereNull('statut')
                    ->orWhere('statut', '<>', 'validee');
            })
            ->latest('date_debut')
            ->get();
        $demandesParStatut = (clone $demandes)
            ->get(['statut'])
            ->groupBy(fn($demande) => $demande->statut ?: 'non_renseigne')
            ->map->count();
        $presencesParMois = presence::query()
            ->whereYear('DATE', $annee)
            ->selectRaw('MONTH(`DATE`) as mois, COUNT(DISTINCT employe_id) as total')
            ->groupByRaw('MONTH(`DATE`)')
            ->pluck('total', 'mois');
        $presencesMensuelles = collect(range(1, 12))->map(fn($mois) => [
            'mois' => $mois,
            'presences' => (int) $presencesParMois->get($mois, 0),
        ]);

        $nb = [
            'utilisateurs' => User::count(),
            'employes' => employe::count(),
            'les_employes_affectes' => affectation::query()
                ->when($anneeId, fn($query) => $query->where('annee_id', $anneeId))
                ->distinct('employe_id')
                ->count('employe_id'),
            'les_demandes_conges_mois' => (clone $demandes)
                ->whereMonth('date_debut', now()->month)
                ->count(),
            'les_demande_conges_anné' => (clone $demandes)->count(),
            'demandes_en_attente' => $demandesNonValidees->count(),
            'demandes_non_validees' => $demandesNonValidees,
            'demandes_par_statut' => $demandesParStatut,
            'presences_mensuelles' => $presencesMensuelles,
            'annee' => $annee,
        ];

        return $nb;
    }



    //les profiles
    public function accueil_dg()
    {
        $nb = $this->var_dashboard();
        $user = Auth::user();
        $les_utilisateurs = $nb['utilisateurs'] ?? 0;
        $les_employes = $nb['employes'] ?? 0;
        $les_affectations = $nb['les_employes_affectes'] ?? 0;
        $les_demandes_conges_annee = $nb['les_demande_conges_anné'] ?? 0;
        $les_demandes_conges_mois = $nb['les_demandes_conges_mois'] ?? 0;
        $demandes_en_attente = $nb['demandes_en_attente'] ?? 0;
        $demandesNonValidees = $nb['demandes_non_validees'] ?? collect();
        $demandesParStatut = $nb['demandes_par_statut'] ?? collect();
        $presencesMensuelles = $nb['presences_mensuelles'] ?? collect();
        $annee = $nb['annee'] ?? now()->year;

        return view('profile.accueil_dg', compact(
            'user',
            'les_utilisateurs',
            'les_employes',
            'les_affectations',
            'les_demandes_conges_annee',
            'les_demandes_conges_mois',
            'demandes_en_attente',
            'annee',
            'demandesNonValidees',
            'demandesParStatut',
            'presencesMensuelles'
        ));
    }

    public function accueil_secDg()
    {
        $user = Auth::user();
        return view('profile.accueil_secGeneral', compact('user'));
    }

    public function accueil_cs()
    {
        $user = Auth::user();
        return view('profile.accueil_chef_serv', compact('user'));
    }

    public function accueil_cd()
    {
        $user = Auth::user();
        return view('profile.accueil_chef_div', compact('user'));
    }
    public function accueil_cb1()
    {
        $user = Auth::user();
        return view('profile.accueil_bureau1', compact('user'));
    }
    public function accueil_cb2()
    {
        $user = Auth::user();
        return view('profile.accueil_bureau2', compact('user'));
    }
    public function accueil_cb3()
    {
        $user = Auth::user();
        return view('profile.accueil_bureau3', compact('user'));
    }
    public function accueil_employe()
    {
        $user = Auth::user();
        return view('profile.accueil_employe', compact('user'));
    }
}
