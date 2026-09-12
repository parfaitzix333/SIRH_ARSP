<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HandlesCrudHistory;
use App\Models\categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    use HandlesCrudHistory;
    private function rules(): array
    {
        return ['designation' => ['required', 'string', 'max:150'], 'annee_id' => ['required', 'exists:annees,id']];
    }
    public function store(Request $request)
    {
        $data = $request->validate($this->rules());
        $item = categorie::create($data);
        $this->historique('Création de la catégorie : ' . $item->designation, $item->annee_id);
        return back()->with('success', 'Catégorie créée avec succès.');
    }
    public function update(Request $request, $id)
    {
        $item = categorie::findOrFail($id);
        $data = $request->validate($this->rules());
        $item->update($data);
        $this->historique('Mise à jour de la catégorie : ' . $item->designation, $item->annee_id);
        return back()->with('success', 'Catégorie mise à jour avec succès.');
    }
    public function destroy($id)
    {
        $item = categorie::findOrFail($id);
        $name = $item->designation;
        $anneeId = $item->annee_id;
        $item->delete();
        $this->historique('Suppression de la catégorie : ' . $name, $anneeId);
        return back()->with('success', 'Catégorie supprimée avec succès.');
    }
}
