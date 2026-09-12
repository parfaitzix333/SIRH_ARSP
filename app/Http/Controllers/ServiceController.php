<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HandlesCrudHistory;
use App\Models\service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    use HandlesCrudHistory;
    private function rules(): array
    {
        return ['nom_service' => ['required', 'string', 'max:150'], 'domaine' => ['nullable', 'string', 'max:150'], 'annee_id' => ['required', 'exists:annees,id']];
    }
    public function store(Request $request)
    {
        $data = $request->validate($this->rules());
        $item = service::create($data);
        $this->historique('Création du service : ' . $item->nom_service, $item->annee_id);
        return back()->with('success', 'Service créé avec succès.');
    }
    public function update(Request $request, $id)
    {
        $item = service::findOrFail($id);
        $data = $request->validate($this->rules());
        $item->update($data);
        $this->historique('Mise à jour du service : ' . $item->nom_service, $item->annee_id);
        return back()->with('success', 'Service mis à jour avec succès.');
    }
    public function destroy($id)
    {
        $item = service::findOrFail($id);
        $name = $item->nom_service;
        $anneeId = $item->annee_id;
        $item->delete();
        $this->historique('Suppression du service : ' . $name, $anneeId);
        return back()->with('success', 'Service supprimé avec succès.');
    }
}
