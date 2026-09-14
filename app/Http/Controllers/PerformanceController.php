<?php

namespace App\Http\Controllers;

use App\Models\performance;
use Illuminate\Http\Request;

class PerformanceController extends Controller
{
    private function rules(): array
    {
        return [
            'employe_id' => ['required', 'exists:employes,id'],
            'evaluateur_id' => ['nullable', 'exists:users,id'],
            'periode_debut' => ['required', 'date'],
            'periode_fin' => ['required', 'date', 'after_or_equal:periode_debut'],
            'objectifs' => ['nullable', 'string'],
            'qualite_travail' => ['nullable', 'numeric', 'between:0,10'],
            'productivite' => ['nullable', 'numeric', 'between:0,10'],
            'ponctualite' => ['nullable', 'numeric', 'between:0,10'],
            'assiduite' => ['nullable', 'numeric', 'between:0,10'],
            'comportement' => ['nullable', 'numeric', 'between:0,10'],
            'travail_equipe' => ['nullable', 'numeric', 'between:0,10'],
            'cote_generale' => ['nullable', 'numeric', 'between:0,10'],
            'appreciation' => ['nullable', 'string'],
            'recommandations' => ['nullable', 'string'],
            'statut' => ['nullable', 'in:brouillon,soumise,validee'],
            'annee_id' => ['required', 'exists:annees,id'],
        ];
    }

    private function calculerCoteGenerale(array $data): float
    {
        $scores = [
            $data['qualite_travail'] ?? null,
            $data['productivite'] ?? null,
            $data['ponctualite'] ?? null,
            $data['assiduite'] ?? null,
            $data['comportement'] ?? null,
            $data['travail_equipe'] ?? null,
        ];

        $scores = array_values(array_filter($scores, fn($value) => $value !== null && $value !== ''));

        if (empty($scores)) {
            return 0.0;
        }

        $total = round(array_sum(array_map('floatval', $scores)), 2);

        return min(max($total, 0), 60);
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());
        $data['statut'] = $data['statut'] ?? 'brouillon';
        $data['cote_generale'] = $this->calculerCoteGenerale($data);

        $item = performance::create($data);

        return back()->with('success', 'Performance créée avec succès.');
    }

    public function update(Request $request, $id)
    {
        $item = performance::findOrFail($id);
        $data = $request->validate($this->rules());
        $data['cote_generale'] = $this->calculerCoteGenerale($data);

        $item->update($data);

        return back()->with('success', 'Performance mise à jour avec succès.');
    }

    public function destroy($id)
    {
        $item = performance::findOrFail($id);
        $item->delete();

        return back()->with('success', 'Performance supprimée avec succès.');
    }
}
