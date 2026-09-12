<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HandlesCrudHistory;
use App\Models\mouvement;
use Illuminate\Http\Request;

class MouvementController extends Controller
{
    use HandlesCrudHistory;
    private function rules(): array
    {
        return ['mouvement' => ['required', 'in:Entrée,Sortie'], 'employe_id' => ['required', 'exists:employes,id'], 'heure' => ['required', 'date_format:H:i']];
    }
    public function store(Request $request)
    {
        $data = $request->validate($this->rules());
        $item = mouvement::create($data);
        $this->historique('Création du mouvement #' . $item->id);
        return back()->with('success', 'Mouvement créé avec succès.');
    }
    public function update(Request $request, $id)
    {
        $item = mouvement::findOrFail($id);
        $data = $request->validate($this->rules());
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
