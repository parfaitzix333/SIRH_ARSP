<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HandlesCrudHistory;
use App\Models\communique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommuniqueController extends Controller
{
    use HandlesCrudHistory;

    public function store(Request $request)
    {
        $data = $request->validate([
            'titre' => ['required', 'string', 'max:255'],
            'contenu' => ['required', 'string'],
            'piece_jointe' => ['nullable', 'string', 'max:255'],
            'role_cible' => ['nullable', 'string', 'max:100'],
            'user_id' => ['nullable', 'exists:users,id'],
            'date_publication' => ['nullable', 'date'],
            'annee_id' => ['required', 'exists:annees,id'],
        ]);
        $item = communique::create($data);
        $this->historique('Création du communiqué : ' . $item->titre, $item->annee_id);
        return back()->with('success', 'Communiqué créé avec succès.');
    }

    public function update(Request $request, $id)
    {
        $item = communique::findOrFail($id);
        $data = $request->validate([
            'titre' => ['required', 'string', 'max:255'],
            'contenu' => ['required', 'string'],
            'piece_jointe' => ['nullable', 'string', 'max:255'],
            'role_cible' => ['nullable', 'string', 'max:100'],
            'user_id' => ['nullable', 'exists:users,id'],
            'date_publication' => ['nullable', 'date'],
            'annee_id' => ['required', 'exists:annees,id'],
        ]);
        $item->update($data);
        $this->historique('Mise à jour du communiqué : ' . $item->titre, $item->annee_id);
        return back()->with('success', 'Communiqué mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $item = communique::findOrFail($id);
        $title = $item->titre;
        $anneeId = $item->annee_id;
        $item->delete();
        $this->historique('Suppression du communiqué : ' . $title, $anneeId);
        return back()->with('success', 'Communiqué supprimé avec succès.');
    }
}
