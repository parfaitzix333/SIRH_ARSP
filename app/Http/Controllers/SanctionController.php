<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HandlesCrudHistory;
use App\Models\sanction;
use Illuminate\Http\Request;

class SanctionController extends Controller
{
    use HandlesCrudHistory;
    private function rules(): array
    {
        return ['designation' => ['required', 'string', 'max:200'], 'annee_id' => ['required', 'exists:annees,id']];
    }
    public function store(Request $request)
    {
        $data = $request->validate($this->rules());
        $item = sanction::create($data);
        $this->historique('Création de la sanction : ' . $item->designation, $item->annee_id);
        return back()->with('success', 'Sanction créée avec succès.');
    }
    public function update(Request $request, $id)
    {
        $item = sanction::findOrFail($id);
        $data = $request->validate($this->rules());
        $item->update($data);
        $this->historique('Mise à jour de la sanction : ' . $item->designation, $item->annee_id);
        return back()->with('success', 'Sanction mise à jour avec succès.');
    }
    public function destroy($id)
    {
        $item = sanction::findOrFail($id);
        $name = $item->designation;
        $anneeId = $item->annee_id;
        $item->delete();
        $this->historique('Suppression de la sanction : ' . $name, $anneeId);
        return back()->with('success', 'Sanction supprimée avec succès.');
    }
}
