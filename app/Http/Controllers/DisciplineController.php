<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HandlesCrudHistory;
use App\Models\discipline;
use Illuminate\Http\Request;

class DisciplineController extends Controller
{
    use HandlesCrudHistory;
    private function rules(): array
    {
        return ['employe_id' => ['required', 'exists:employes,id'], 'sanction_id' => ['nullable', 'exists:sanctions,id'], 'etat' => ['required', 'in:declaree,levee'], 'DATE' => ['required', 'date'], 'contenu' => ['required', 'string'], 'annee_id' => ['required', 'exists:annees,id']];
    }
    public function store(Request $request)
    {
        $data = $request->validate($this->rules());
        $item = discipline::create($data);
        $this->historique('Création de la discipline #' . $item->id, $item->annee_id);
        return back()->with('success', 'Discipline créée avec succès.');
    }
    public function update(Request $request, $id)
    {
        $item = discipline::findOrFail($id);
        $data = $request->validate($this->rules());
        $item->update($data);
        $this->historique('Mise à jour de la discipline #' . $item->id, $item->annee_id);
        return back()->with('success', 'Discipline mise à jour avec succès.');
    }
    public function destroy($id)
    {
        $item = discipline::findOrFail($id);
        $anneeId = $item->annee_id;
        $item->delete();
        $this->historique('Suppression de la discipline #' . $id, $anneeId);
        return back()->with('success', 'Discipline supprimée avec succès.');
    }
}
