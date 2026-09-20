<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HandlesCrudHistory;
use App\Models\annee;
use App\Models\employe;
use App\Models\interime;
use App\Models\demandes_conge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InterimeController extends Controller
{
    use HandlesCrudHistory;

    private function anneeCourante(): ?annee
    {
        $anneeId = session('annee_id') ?? Auth::user()?->annee_id;

        return ($anneeId ? annee::find($anneeId) : null)
            ?? annee::where('statut', 'active')->first();
    }

    private function rules(): array
    {
        return [
            'employe_id' => ['required', 'exists:employes,id'],
            'interimaire_id' => ['nullable', 'different:employe_id', 'exists:employes,id'],
            'date_debut' => ['nullable', 'date'],
            'date_fin' => ['nullable', 'date', 'after_or_equal:date_debut'],
            'annee_id' => ['required', 'exists:annees,id'],
        ];
    }

    public function index(string $profil)
    {
        abort_unless(in_array($profil, ['dg', 'cs', 'secdg'], true), 404);

        $annee = $this->anneeCourante();
        $interims = interime::with(['employe', 'interimaire', 'annee'])
            ->when($annee, fn($query) => $query->where('annee_id', $annee->id))
            ->latest()
            ->get();

        return view($profil . '.les_interims', [
            'user' => Auth::user(),
            'les_interims' => $interims,
            'annee' => $annee,
        ]);
    }

    public function store(Request $request)
    {
        $item = interime::create($request->validate($this->rules()));
        $this->historique('Création de l’intérim #' . $item->id, $item->annee_id);

        return back()->with('success', 'Intérim créé avec succès.');
    }

    public function update(Request $request, $id)
    {
        $item = interime::findOrFail($id);
        $data = $request->validate($this->rules());
        $item->update($data);
        $demande = demandes_conge::query()
            ->where('employe_id', $item->employe_id)
            ->where('annee_id', $item->annee_id)
            ->where('statut', 'validee')
            ->latest('date_validation')
            ->latest('id')
            ->first();

        if ($demande) {
            $demande->update(['interimaire_id' => $item->interimaire_id]);
        }
        $this->historique('Mise à jour de l’intérim #' . $item->id, $item->annee_id);

        return back()->with('success', 'Intérim mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $item = interime::findOrFail($id);
        $anneeId = $item->annee_id;
        $item->delete();
        $this->historique('Suppression de l’intérim #' . $id, $anneeId);

        return back()->with('success', 'Intérim supprimé avec succès.');
    }
}
