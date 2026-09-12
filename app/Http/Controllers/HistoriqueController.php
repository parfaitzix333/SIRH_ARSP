<?php

namespace App\Http\Controllers;

use App\Models\historique;
use Illuminate\Http\Request;
use App\Http\Controllers\Concerns\HandlesCrudHistory;
use Illuminate\Support\Facades\Auth;

class HistoriqueController extends Controller
{
    use HandlesCrudHistory;
    public function destroy($id)
    {
        historique::findOrFail($id)->delete();
        $user = Auth::user();
        $this->historique('Suppression d\'une trace' . ' par ' . $user->name);

        return back()->with('success', 'Historique supprimé avec succès.');
    }

    public function clearAll()
    {
        $user = Auth::user();
        historique::query()->delete();
        $this->historique('Suppression de tous les historiques' . ' par ' . $user->name);

        return back()->with('success', 'Les historiques ont été supprimés.');
    }

    public function deleteSelected(Request $request)
    {
        $data = $request->validate([
            'selected' => ['required', 'array'],
            'selected.*' => ['integer', 'exists:historiques,id'],
        ]);
        $user = Auth::user();

        historique::whereIn('id', $data['selected'])->delete();
        $this->historique('Suppression de tous les historiques sélectionnées' . ' par ' . $user->name);

        return back()->with('success', 'Les historiques sélectionnés ont été supprimés.');
    }
}
