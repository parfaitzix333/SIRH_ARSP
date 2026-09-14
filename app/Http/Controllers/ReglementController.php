<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HandlesCrudHistory;
use App\Models\reglement;
use Illuminate\Http\Request;

class ReglementController extends Controller
{
    use HandlesCrudHistory;

    private function rules(): array
    {
        return [
            'numero' => ['required', 'integer'],
            'titre' => ['required', 'string', 'max:500'],
            'designation' => ['required', 'string', 'max:1000'],
        ];
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());
        $item = reglement::create($data);
        $this->historique('Création du règlement #' . $item->numero);
        return back()->with('success', 'Règlement créé avec succès.');
    }

    public function update(Request $request, $id)
    {
        $item = reglement::findOrFail($id);
        $item->update($request->validate($this->rules()));
        $this->historique('Mise à jour du règlement #' . $item->numero);
        return back()->with('success', 'Règlement mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $item = reglement::findOrFail($id);
        $numero = $item->numero;
        $item->delete();
        $this->historique('Suppression du règlement #' . $numero);
        return back()->with('success', 'Règlement supprimé avec succès.');
    }
}
