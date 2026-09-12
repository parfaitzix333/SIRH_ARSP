<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HandlesCrudHistory;
use App\Models\conge;
use Illuminate\Http\Request;

class CongeController extends Controller
{
    use HandlesCrudHistory;
    private function rules(): array
    {
        return ['designation' => ['required', 'string', 'max:150'], 'TYPE' => ['required', 'in:paye,non_paye'], 'indice' => ['required', 'in:++,--'], 'actif' => ['sometimes', 'boolean'], 'annee_id' => ['required', 'exists:annees,id']];
    }
    public function store(Request $request)
    {
        $data = $request->validate($this->rules());
        $data['actif'] = $data['actif'] ?? true;
        $item = conge::create($data);
        $this->historique('Création du type de congé : ' . $item->designation, $item->annee_id);
        return back()->with('success', 'Type de congé créé avec succès.');
    }
    public function update(Request $request, $id)
    {
        $item = conge::findOrFail($id);
        $data = $request->validate($this->rules());
        $data['actif'] = $data['actif'] ?? false;
        $item->update($data);
        $this->historique('Mise à jour du type de congé : ' . $item->designation, $item->annee_id);
        return back()->with('success', 'Type de congé mis à jour avec succès.');
    }
    public function destroy($id)
    {
        $item = conge::findOrFail($id);
        $name = $item->designation;
        $anneeId = $item->annee_id;
        $item->delete();
        $this->historique('Suppression du type de congé : ' . $name, $anneeId);
        return back()->with('success', 'Type de congé supprimé avec succès.');
    }
}
