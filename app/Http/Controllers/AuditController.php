<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HandlesCrudHistory;
use App\Models\audit;
use Illuminate\Http\Request;

class AuditController extends Controller
{
    use HandlesCrudHistory;

    private function rules(): array
    {
        return ['employe_id' => ['required', 'exists:employes,id'], 'role' => ['required', 'string', 'max:100'], 'ordre' => ['required', 'integer'], 'date_debut_service' => ['nullable', 'date'], 'date_fin_service' => ['nullable', 'date', 'after_or_equal:date_debut_service'], 'annee_id' => ['required', 'exists:annees,id']];
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());
        $item = audit::create($data);
        $this->historique('Création de l’audit #' . $item->id, $item->annee_id);
        return back()->with('success', 'Audit créé avec succès.');
    }
    public function update(Request $request, $id)
    {
        $item = audit::findOrFail($id);
        $data = $request->validate($this->rules());
        $item->update($data);
        $this->historique('Mise à jour de l’audit #' . $item->id, $item->annee_id);
        return back()->with('success', 'Audit mis à jour avec succès.');
    }
    public function destroy($id)
    {
        $item = audit::findOrFail($id);
        $anneeId = $item->annee_id;
        $item->delete();
        $this->historique('Suppression de l’audit #' . $id, $anneeId);
        return back()->with('success', 'Audit supprimé avec succès.');
    }
}
