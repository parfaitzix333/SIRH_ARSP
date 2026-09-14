<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HandlesCrudHistory;
use App\Models\annee;
use App\Models\mouvement;
use Illuminate\Http\Request;

class MouvementController extends Controller
{
    use HandlesCrudHistory;

    private function normalizeHeure(Request $request): void
    {
        $heure = $request->input('heure');

        if (is_string($heure) && preg_match('/^\d{2}:\d{2}:\d{2}$/', $heure)) {
            $request->merge(['heure' => substr($heure, 0, 5)]);
        }
    }

    private function rules(): array
    {
        return ['mouvement' => ['required', 'in:Entrée,Sortie'], 'employe_id' => ['required', 'exists:employes,id'], 'heure' => ['required', 'regex:/^\d{2}:\d{2}(:\d{2})?$/']];
    }

    public function store(Request $request)
    {
        $this->normalizeHeure($request);

        $annee = annee::where('statut', 'active')->value('id');
        $data = $request->validate($this->rules());
        $data['annee_id'] = $annee;
        $item = mouvement::create($data);
        $this->historique('Création du mouvement #' . $item->id);
        return back()->with('success', 'Mouvement créé avec succès.');
    }

    public function update(Request $request, $id)
    {
        $this->normalizeHeure($request);

        $annee = annee::where('statut', 'active')->value('id');
        $item = mouvement::findOrFail($id);
        $data = $request->validate($this->rules());
        $data['annee_id'] = $annee;
        $item->update($data);
        $this->historique('Mise à jour du mouvement #' . $item->id);
        return back()->with('success', 'Mouvement mis à jour avec succès.');
    }
    public function destroy($id)
    {
        $item = mouvement::findOrFail($id);
        $item->delete();
        $this->historique('Suppression du mouvement #' . $id);
        return back()->with('success', 'Mouvement supprimé avec succès.');
    }
}
