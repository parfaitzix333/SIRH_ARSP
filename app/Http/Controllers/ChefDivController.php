<?php

namespace App\Http\Controllers;

use App\Models\annee;
use App\Models\affectation;
use App\Models\archive;
use App\Models\audit;
use App\Models\categorie;
use App\Models\communique;
use App\Models\conge;
use App\Models\contact;
use App\Models\demandes_conge;
use App\Models\discipline;
use App\Models\dossiers_etude;
use App\Models\employe;
use App\Models\formation;
use App\Models\formation_employe;
use App\Models\grade;
use App\Models\historique;
use App\Models\mouvement;
use App\Models\poste;
use App\Models\presence;
use App\Models\performance;
use App\Models\propriete;
use App\Models\reglement;
use App\Models\sanction;
use App\Models\service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChefDivController extends Controller
{
    private function anneeCourante(): ?annee
    {
        $anneeSelectionnee = session('annee_id');

        if ($anneeSelectionnee) {
            return annee::find($anneeSelectionnee) ?? annee::where('statut', 'active')->first();
        }

        $anneeUtilisateur = Auth::user()?->annee_id;

        if ($anneeUtilisateur) {
            return annee::find($anneeUtilisateur) ?? annee::where('statut', 'active')->first();
        }

        return annee::where('statut', 'active')->first();
    }

    private function parAnnee(string $model)
    {
        $annee = $this->anneeCourante();

        return $annee ? $model::where('annee_id', $annee->id)->get() : collect();
    }

    public function switcher_annee(Request $request)
    {
        $validated = $request->validate([
            'annee_id' => ['required', 'exists:annees,id'],
        ]);

        $user = $request->user();

        if ($user) {
            $user->annee_id = $validated['annee_id'];
            $user->save();
        }

        session(['annee_id' => $validated['annee_id']]);

        return back()->with('success', 'Année sélectionnée avec succès.');
    }

    // Pages du directeur général provincial selon l'année courante.
    public function les_contacts()
    {
        $user = Auth::user();
        $les_contacts = $this->parAnnee(contact::class);
        return view('cd.les_contacts', compact('user', 'les_contacts'));
    }

    public function les_communiques()
    {
        $user = Auth::user();
        $les_communiques = $this->parAnnee(communique::class);
        return view('cd.les_communiques', compact('user', 'les_communiques'));
    }

    public function les_posts()
    {
        $user = Auth::user();
        $les_posts = $this->parAnnee(poste::class);
        return view('cd.les_posts', compact('user', 'les_posts'));
    }

    public function les_demandes_conge()
    {
        return $this->vueAvecCollection('les_demandes_conge', 'les_demandes_conge', demandes_conge::class);
    }

    public function les_conges()
    {
        return $this->vueAvecCollection('les_conges', 'les_conges', conge::class);
    }

    public function les_categories()
    {
        return $this->vueAvecCollection('les_categories', 'les_categories', categorie::class);
    }

    public function les_audits()
    {
        return $this->vueAvecCollection('les_audits', 'les_audits', audit::class);
    }

    public function les_archives()
    {
        return $this->vueAvecCollection('les_archives', 'les_archives', archive::class);
    }
    public function les_grades()
    {
        $user = Auth::user();
        $les_grades = grade::withCount('employes')->orderBy('numero')->orderBy('designation')->get();

        return view('cd.les_grades', compact('user', 'les_grades'));
    }

    public function les_annees()
    {
        $user = Auth::user();
        $les_annees = annee::orderByDesc('annee')->get();

        return view('cd.les_annees', compact('user', 'les_annees'));
    }

    public function les_affectations()
    {
        return $this->vueAvecCollection('les_affectations', 'les_affectations', affectation::class);
    }

    public function historique()
    {
        $user = Auth::user();
        $annee = $this->anneeCourante();
        $historiques = historique::with(['user', 'annee'])
            ->when($annee, fn($query) => $query->where('annee_id', $annee->id))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('cd.historique', compact('user', 'historiques'));
    }

    public function les_disciplines()
    {
        return $this->vueAvecCollection('les_disciplines', 'les_disciplines', discipline::class);
    }

    public function les_dossiers_etude()
    {
        return $this->vueAvecCollection('les_dossiers_etude', 'les_dossiers_etude', dossiers_etude::class);
    }

    public function les_dossiers_etudes()
    {
        return $this->vueAvecCollection('les_dossiers_etudes', 'les_dossiers_etudes', dossiers_etude::class);
    }

    public function les_employes()
    {
        return $this->vueAvecCollection('les_employes', 'les_employes', employe::class);
    }

    public function les_formations()
    {
        return $this->vueAvecCollection('les_formations', 'les_formations', formation::class);
    }

    public function les_formations_employes()
    {
        return $this->vueAvecCollection('les_formations_employes', 'les_formations_employes', formation_employe::class);
    }

    public function les_mouvements()
    {
        return $this->vueAvecCollection('les_mouvements', 'les_mouvements', mouvement::class);
    }

    public function les_performances()
    {
        return $this->vueAvecCollection('les_performances', 'les_performances', performance::class);
    }

    public function les_presences()
    {
        return $this->vueAvecCollection('les_presences', 'les_presences', presence::class);
    }

    public function les_proprietes()
    {
        return $this->vueAvecCollection('les_proprietes', 'les_proprietes', propriete::class);
    }

    public function les_reglements()
    {
        $user = Auth::user();
        $les_reglements = reglement::orderBy('numero')->get();

        return view('cd.les_reglements', compact('user', 'les_reglements'));
    }

    public function les_sanctions()
    {
        return $this->vueAvecCollection('les_sanctions', 'les_sanctions', sanction::class);
    }

    public function les_services()
    {
        return $this->vueAvecCollection('les_services', 'les_services', service::class);
    }

    public function les_utilisateurs()
    {
        $user = Auth::user();
        $les_utilisateurs = User::orderBy('name')->get();

        return view('cd.les_utilisateurs', compact('user', 'les_utilisateurs'));
    }

    private function vueAvecCollection(string $vue, string $variable, string $model)
    {
        $user = Auth::user();
        ${$variable} = $this->parAnnee($model);

        return view('cd.' . $vue, compact('user', $variable));
    }
}
