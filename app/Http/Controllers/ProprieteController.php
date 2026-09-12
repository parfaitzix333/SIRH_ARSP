<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HandlesCrudHistory;
use App\Models\propriete;
use Illuminate\Http\Request;

class ProprieteController extends Controller
{
    use HandlesCrudHistory;
    private function rules(): array
    {
        return ['titre' => ['required', 'string', 'max:200'], 'nos_info' => ['nullable', 'string'], 'annee_id' => ['required', 'exists:annees,id']];
    }
    public function store(Request $request)
    {
        $data = $request->validate($this->rules());
        $item = propriete::create($data);
        $this->historique('Création de la propriété : ' . $item->titre, $item->annee_id);
        return back()->with('success', 'Propriété créée avec succès.');
    }
    public function update(Request $request, $id)
    {
        $item = propriete::findOrFail($id);
        $data = $request->validate($this->rules());
        $item->update($data);
        $this->historique('Mise à jour de la propriété : ' . $item->titre, $item->annee_id);
        return back()->with('success', 'Propriété mise à jour avec succès.');
    }
    public function destroy($id)
    {
        $item = propriete::findOrFail($id);
        $title = $item->titre;
        $anneeId = $item->annee_id;
        $item->delete();
        $this->historique('Suppression de la propriété : ' . $title, $anneeId);
        return back()->with('success', 'Propriété supprimée avec succès.');
    }
}
