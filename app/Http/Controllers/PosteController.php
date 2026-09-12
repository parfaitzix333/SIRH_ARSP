<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HandlesCrudHistory;
use App\Models\poste;
use Illuminate\Http\Request;

class PosteController extends Controller
{
    use HandlesCrudHistory;
    private function rules(): array
    {
        return ['intitule' => ['required', 'string', 'max:150'], 'description' => ['nullable', 'string'], 'annee_id' => ['required', 'exists:annees,id']];
    }
    public function store(Request $request)
    {
        $data = $request->validate($this->rules());
        $item = poste::create($data);
        $this->historique('Création du poste : ' . $item->intitule, $item->annee_id);
        return back()->with('success', 'Poste créé avec succès.');
    }
    public function update(Request $request, $id)
    {
        $item = poste::findOrFail($id);
        $data = $request->validate($this->rules());
        $item->update($data);
        $this->historique('Mise à jour du poste : ' . $item->intitule, $item->annee_id);
        return back()->with('success', 'Poste mis à jour avec succès.');
    }
    public function destroy($id)
    {
        $item = poste::findOrFail($id);
        $name = $item->intitule;
        $anneeId = $item->annee_id;
        $item->delete();
        $this->historique('Suppression du poste : ' . $name, $anneeId);
        return back()->with('success', 'Poste supprimé avec succès.');
    }
}
