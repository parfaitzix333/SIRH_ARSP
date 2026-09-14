<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HandlesCrudHistory;
use App\Models\affectation;
use Illuminate\Http\Request;

class AffectationController extends Controller
{
    use HandlesCrudHistory;

    private function rules(): array
    {
        return [
            'employe_id' => ['required', 'exists:employes,id'],
            'service_id' => ['required', 'exists:services,id'],
            'categorie_id' => ['nullable', 'exists:categories,id'],
            'poste_id' => ['nullable', 'exists:postes,id'],
            'date_debut' => ['nullable', 'date'],
            'date_fin' => ['nullable', 'date', 'after_or_equal:date_debut'],
            'annee_id' => ['required', 'exists:annees,id'],
        ];
    }

    public function store(Request $request)
    {
        $item = affectation::create($request->validate($this->rules()));
        $this->historique('Création de l’affectation #' . $item->id, $item->annee_id);

        return back()->with('success', 'Affectation créée avec succès.');
    }

    public function update(Request $request, $id)
    {
        $item = affectation::findOrFail($id);
        $item->update($request->validate($this->rules()));
        $this->historique('Mise à jour de l’affectation #' . $item->id, $item->annee_id);

        return back()->with('success', 'Affectation mise à jour avec succès.');
    }

    public function destroy($id)
    {
        $item = affectation::findOrFail($id);
        $anneeId = $item->annee_id;
        $item->delete();
        $this->historique('Suppression de l’affectation #' . $id, $anneeId);

        return back()->with('success', 'Affectation supprimée avec succès.');
    }
}
