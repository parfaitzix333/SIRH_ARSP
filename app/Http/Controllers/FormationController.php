<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HandlesCrudHistory;
use App\Models\formation;
use Illuminate\Http\Request;

class FormationController extends Controller
{
    use HandlesCrudHistory;
    private function rules(): array
    {
        return ['domaine' => ['nullable', 'string', 'max:150'], 'intitule' => ['required', 'string', 'max:200'], 'date_debut' => ['required', 'date'], 'date_fin' => ['required', 'date', 'after_or_equal:date_debut'], 'nb_jour' => ['nullable', 'integer', 'min:0'], 'annee_id' => ['required', 'exists:annees,id']];
    }
    public function store(Request $request)
    {
        $data = $request->validate($this->rules());
        $item = formation::create($data);
        $this->historique('Création de la formation : ' . $item->intitule, $item->annee_id);
        return back()->with('success', 'Formation créée avec succès.');
    }
    public function update(Request $request, $id)
    {
        $item = formation::findOrFail($id);
        $data = $request->validate($this->rules());
        $item->update($data);
        $this->historique('Mise à jour de la formation : ' . $item->intitule, $item->annee_id);
        return back()->with('success', 'Formation mise à jour avec succès.');
    }
    public function destroy($id)
    {
        $item = formation::findOrFail($id);
        $title = $item->intitule;
        $anneeId = $item->annee_id;
        $item->delete();
        $this->historique('Suppression de la formation : ' . $title, $anneeId);
        return back()->with('success', 'Formation supprimée avec succès.');
    }
}
