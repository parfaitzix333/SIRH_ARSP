<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HandlesCrudHistory;
use App\Models\demandes_conge;
use Illuminate\Http\Request;

class DemandeCongeController extends Controller
{
    use HandlesCrudHistory;
    private function rules(): array
    {
        return ['employe_id' => ['required', 'exists:employes,id'], 'conge_id' => ['required', 'exists:conges,id'], 'date_debut' => ['required', 'date'], 'date_fin' => ['required', 'date', 'after_or_equal:date_debut'], 'nombre_jour' => ['required', 'integer', 'min:1'], 'motif' => ['nullable', 'string'], 'statut' => ['sometimes', 'in:brouillon,soumise,validee,refusee,annulee'], 'valide_par' => ['nullable', 'exists:users,id'], 'date_validation' => ['nullable', 'date'], 'commentaire_validation' => ['nullable', 'string'], 'annee_id' => ['required', 'exists:annees,id']];
    }
    public function store(Request $request)
    {
        $data = $request->validate($this->rules());
        $data['statut'] = $data['statut'] ?? 'soumise';
        $item = demandes_conge::create($data);
        $this->historique('Création de la demande de congé #' . $item->id, $item->annee_id);
        return back()->with('success', 'Demande de congé créée avec succès.');
    }
    public function update(Request $request, $id)
    {
        $item = demandes_conge::findOrFail($id);
        $data = $request->validate($this->rules());
        $item->update($data);
        $this->historique('Mise à jour de la demande de congé #' . $item->id, $item->annee_id);
        return back()->with('success', 'Demande de congé mise à jour avec succès.');
    }
    public function destroy($id)
    {
        $item = demandes_conge::findOrFail($id);
        $anneeId = $item->annee_id;
        $item->delete();
        $this->historique('Suppression de la demande de congé #' . $id, $anneeId);
        return back()->with('success', 'Demande de congé supprimée avec succès.');
    }
}
