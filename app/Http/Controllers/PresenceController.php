<?php

namespace App\Http\Controllers;

use App\Models\presence;
use Illuminate\Http\Request;

class PresenceController extends Controller
{
    private function rules(): array
    {
        return [
            'employe_id' => ['required', 'exists:employes,id'],
            'DATE' => ['required', 'date'],
            'heure' => ['required', 'regex:/^([01]\d|2[0-3]):[0-5]\d(:[0-5]\d)?$/'],
            'mouvement' => ['required', 'in:entree,sortie'],
            'score_reconnaissance' => ['nullable', 'numeric', 'between:0,1'],
            'SOURCE' => ['nullable', 'string', 'max:50'],
            'synchronise' => ['nullable', 'boolean'],
            'synced_at' => ['nullable', 'date'],
            'annee_id' => ['required', 'exists:annees,id'],
            'autorisation' => ['nullable', 'in:oui,non'],
        ];
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());
        $data['SOURCE'] = $data['SOURCE'] ?? 'desktop';
        $data['synchronise'] = filter_var($data['synchronise'] ?? false, FILTER_VALIDATE_BOOLEAN);
        $data['autorisation'] = $data['autorisation'] ?? 'non';

        $item = presence::create($data);

        return back()->with('success', 'Présence enregistrée avec succès.');
    }

    public function update(Request $request, $id)
    {
        $item = presence::findOrFail($id);
        $data = $request->validate($this->rules());

        $data['SOURCE'] = $data['SOURCE'] ?? $item->SOURCE ?? 'desktop';
        $data['synchronise'] = filter_var($data['synchronise'] ?? $item->synchronise, FILTER_VALIDATE_BOOLEAN);
        $data['autorisation'] = $data['autorisation'] ?? $item->autorisation ?? 'non';

        $item->update($data);

        return back()->with('success', 'Présence mise à jour avec succès.');
    }

    public function destroy($id)
    {
        $item = presence::findOrFail($id);
        $item->delete();

        return back()->with('success', 'Présence supprimée avec succès.');
    }
}
