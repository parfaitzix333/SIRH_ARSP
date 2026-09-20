<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HandlesCrudHistory;
use App\Models\communique;
use App\Models\annee;
use App\Models\conge;
use App\Models\demandes_conge;
use App\Models\employe;
use App\Models\service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EmployeController extends Controller
{
    use HandlesCrudHistory;
    private function rules(?int $ignoreId = null): array
    {
        return ['matricule' => ['required', 'string', 'max:50', Rule::unique('employes', 'matricule')->ignore($ignoreId)], 'nom' => ['required', 'string', 'max:150'], 'grade_id' => ['nullable', 'exists:grades,id'], 'service_id' => ['nullable', 'exists:services,id'], 'date_naissance' => ['nullable', 'date'], 'date_engagement' => ['nullable', 'date'], 'lieu_naissance' => ['nullable', 'string', 'max:150'], 'province_origine' => ['nullable', 'string', 'max:150'], 'territoire' => ['nullable', 'string', 'max:150'], 'localite' => ['nullable', 'string', 'max:150'], 'niveau_etude' => ['nullable', 'string', 'max:150'], 'user_id' => ['nullable', 'exists:users,id'], 'annee_id' => ['required', 'exists:annees,id']];
    }
    public function store(Request $request)
    {
        $data = $request->validate($this->rules());
        $item = employe::create($data);
        $this->historique('Création de l’employé : ' . $item->nom, $item->annee_id);
        return back()->with('success', 'Employé créé avec succès.');
    }
    public function update(Request $request, $id)
    {
        $item = employe::findOrFail($id);
        $data = $request->validate($this->rules($item->id));
        $item->update($data);
        $this->historique('Mise à jour de l’employé : ' . $item->nom, $item->annee_id);
        return back()->with('success', 'Employé mis à jour avec succès.');
    }
    public function destroy($id)
    {
        $item = employe::findOrFail($id);
        $name = $item->nom;
        $anneeId = $item->annee_id;
        $item->delete();
        $this->historique('Suppression de l’employé : ' . $name, $anneeId);
        return back()->with('success', 'Employé supprimé avec succès.');
    }

    //les pages pour employés
    public function mes_conges()
    {
        $user = Auth::user();
        $employe = employe::where('user_id', $user->id)->firstOrFail();
        $mes_conges = demandes_conge::where('employe_id', $employe->id)
            ->with(['conge', 'validePar', 'annee'])
            ->latest()
            ->get();
        $anneeId = session('annee_id') ?? $user->annee_id ?? annee::where('statut', 'active')->value('id');
        $typesConges = conge::where('annee_id', $anneeId)
            ->where('actif', true)
            ->where('designation', '!=', 'Congé sabatique')
            ->orderBy('designation')
            ->get();
        $demandeAnnuelleBloquee = $mes_conges
            ->whereIn('statut', ['soumise', 'validee'])
            ->contains(fn($demande) => $demande->conge?->designation === 'Congé sabatique');

        return view('emp.mes_conges', compact('user', 'employe', 'mes_conges', 'typesConges', 'demandeAnnuelleBloquee'));
    }

    public function mes_disciplines()
    {
        $user = Auth::user();
        $employe = employe::where('user_id', $user->id)->firstOrFail();
        $mes_disciplines = $employe->disciplines()
            ->with(['sanction', 'annee'])
            ->latest('DATE')
            ->get();

        return view('emp.mes_disciplines', compact('user', 'mes_disciplines'));
    }

    public function mes_presences()
    {
        $user = Auth::user();
        $employe = employe::where('user_id', $user->id)->firstOrFail();
        $mes_presences = $employe->presences()
            ->with('annee')
            ->latest('DATE')
            ->latest('heure')
            ->get();

        return view('emp.mes_presences', compact('user', 'mes_presences'));
    }

    public function mes_communiques()
    {
        $user = Auth::user();

        $employe = employe::where('user_id', $user->id)->firstOrFail();

        $lectures = $employe->lectures()
            ->with('communique')
            ->latest()
            ->get();

        $mes_communiques_non_lu = $lectures->where('lu', false);
        $mes_communiques_lu = $lectures->where('lu', true);

        return view('emp.mes_communiques', compact(
            'user',
            'employe',
            'mes_communiques_lu',
            'mes_communiques_non_lu'
        ));
    }
    public function mon_autorisation(employe $employe)
    {
        $mon_conge = demandes_conge::where('employe_id', $employe->id)->latest()->first();
        $mon_service = service::find($employe->service_id);
        return view('emp.mon_autorisation', compact('employe', 'mon_conge', 'mon_service'));
    }
}
