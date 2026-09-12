<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HandlesCrudHistory;
use App\Models\employe;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EmployeController extends Controller
{
    use HandlesCrudHistory;
    private function rules(?int $ignoreId = null): array
    {
        return ['matricule' => ['required', 'string', 'max:50', Rule::unique('employes', 'matricule')->ignore($ignoreId)], 'nom' => ['required', 'string', 'max:150'], 'grade_id' => ['nullable', 'exists:grades,id'], 'service_id' => ['nullable', 'exists:services,id'], 'date_naissance' => ['nullable', 'date'], 'lieu_naissance' => ['nullable', 'string', 'max:150'], 'province_origine' => ['nullable', 'string', 'max:150'], 'territoire' => ['nullable', 'string', 'max:150'], 'localite' => ['nullable', 'string', 'max:150'], 'niveau_etude' => ['nullable', 'string', 'max:150'], 'user_id' => ['nullable', 'exists:users,id'], 'annee_id' => ['required', 'exists:annees,id']];
    }
    public function store(Request $request)
    {
        $data = $request->validate($this->rules());
        $item = employe::create($data);
        $this->historique('Création de l’employé : ' . $item->nom, $item->annee_id);
        return back()->with('success', 'Employé créé avec succès.');
    }
    public function update(Request $request, $id)
    {
        $item = employe::findOrFail($id);
        $data = $request->validate($this->rules($item->id));
        $item->update($data);
        $this->historique('Mise à jour de l’employé : ' . $item->nom, $item->annee_id);
        return back()->with('success', 'Employé mis à jour avec succès.');
    }
    public function destroy($id)
    {
        $item = employe::findOrFail($id);
        $name = $item->nom;
        $anneeId = $item->annee_id;
        $item->delete();
        $this->historique('Suppression de l’employé : ' . $name, $anneeId);
        return back()->with('success', 'Employé supprimé avec succès.');
    }
}
