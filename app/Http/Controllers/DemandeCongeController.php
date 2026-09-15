<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HandlesCrudHistory;
use App\Models\annee;
use App\Models\conge;
use App\Models\demandes_conge;
use App\Models\employe;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class DemandeCongeController extends Controller
{
    use HandlesCrudHistory;
    private function rules(): array
    {
        return ['employe_id' => ['required', 'exists:employes,id'], 'conge_id' => ['required', 'exists:conges,id'], 'date_debut' => ['required', 'date'], 'date_fin' => ['required', 'date', 'after_or_equal:date_debut'], 'nombre_jour' => ['required', 'integer', 'min:1'], 'motif' => ['nullable', 'string'], 'statut' => ['sometimes', 'in:brouillon,soumise,validee,refusee,annulee'], 'valide_par' => ['nullable', 'exists:users,id'], 'date_validation' => ['nullable', 'date'], 'commentaire_validation' => ['nullable', 'string'], 'annee_id' => ['required', 'exists:annees,id']];
    }
    public function store(Request $request)
    {
        $data = $request->validate($this->rules());
        $data['statut'] = $data['statut'] ?? 'soumise';
        $item = demandes_conge::create($data);
        $this->historique('Création de la demande de congé #' . $item->id, $item->annee_id);
        return back()->with('success', 'Demande de congé créée avec succès.');
    }

    public function storeEmploye(Request $request)
    {
        $employe = employe::where('user_id', Auth::id())->firstOrFail();
        $anneeId = session('annee_id') ?? Auth::user()->annee_id ?? annee::where('statut', 'active')->value('id');

        abort_unless($anneeId, 422, 'Aucune année active n’est disponible.');

        $mode = $request->input('mode', 'annuel');
        abort_unless(in_array($mode, ['annuel', 'circonstanciel'], true), 422, 'Mode de congé invalide.');

        if ($mode === 'annuel') {
            $request->validate([
                'mode' => ['required', 'in:annuel,circonstanciel'],
                'date_debut' => ['required', 'date'],
            ]);

            $demandeAnnuelleExistante = demandes_conge::where('employe_id', $employe->id)
                ->where('annee_id', $anneeId)
                ->whereIn('statut', ['soumise', 'validee'])
                ->whereHas('conge', function ($query) {
                    $query->where('designation', 'Congé sabatique');
                })
                ->exists();

            if ($demandeAnnuelleExistante) {
                throw ValidationException::withMessages([
                    'mode' => 'Vous avez déjà une demande annuelle en attente ou validée pour cette année. Une demande circonstancielle reste possible.',
                ]);
            }

            $dateDebut = Carbon::parse($request->date_debut);
            $dateFin = $dateDebut->copy()->addDays(29);
            $conge = conge::firstOrCreate(
                ['designation' => 'Congé sabatique', 'annee_id' => $anneeId],
                ['TYPE' => 'paye', 'indice' => '++', 'actif' => true],
            );

            $data = [
                'employe_id' => $employe->id,
                'conge_id' => $conge->id,
                'date_debut' => $dateDebut,
                'date_fin' => $dateFin,
                'nombre_jour' => 30,
                'motif' => 'Pause annuel',
                'statut' => 'soumise',
                'annee_id' => $anneeId,
            ];
        } else {
            $validated = $request->validate([
                'mode' => ['required', 'in:annuel,circonstanciel'],
                'conge_id' => ['required', 'exists:conges,id'],
                'date_debut' => ['required', 'date'],
                'date_fin' => ['required', 'date', 'after_or_equal:date_debut'],
                'motif' => ['nullable', 'string', 'max:5000'],
                'piece_justificative' => ['nullable', 'file', 'max:10240'],
            ]);

            $dateDebut = Carbon::parse($validated['date_debut']);
            $dateFin = Carbon::parse($validated['date_fin']);
            abort_unless(
                conge::whereKey($validated['conge_id'])
                    ->where('annee_id', $anneeId)
                    ->where('actif', true)
                    ->exists(),
                422,
                'Le type de congé sélectionné n’est pas disponible pour l’année courante.',
            );
            $validated['employe_id'] = $employe->id;
            $validated['annee_id'] = $anneeId;
            $validated['nombre_jour'] = $dateDebut->diffInDays($dateFin) + 1;
            $validated['statut'] = 'soumise';
            unset($validated['mode']);

            if ($request->hasFile('piece_justificative')) {
                $validated['piece_justificative'] = $request->file('piece_justificative')->store('demandes-conges', 'public');
            }

            $data = $validated;
        }

        $item = demandes_conge::create($data);
        $this->historique('Soumission de la demande de congé #' . $item->id, $anneeId);

        return back()->with('success', 'Votre demande de congé a été soumise avec succès.');
    }
    public function update(Request $request, $id)
    {
        $item = demandes_conge::findOrFail($id);

        if (Auth::user()?->role === 'Chef-Service' && $item->valide_secDg) {
            return back()->withErrors('Cette demande a déjà été traitée par le SecDG et ne peut plus être modifiée.');
        }

        $data = $request->validate($this->rules());
        $item->update($data);
        $this->historique('Mise à jour de la demande de congé #' . $item->id, $item->annee_id);
        return back()->with('success', 'Demande de congé mise à jour avec succès.');
    }
    public function destroy($id)
    {
        $item = demandes_conge::findOrFail($id);

        if (Auth::user()?->role === 'Chef-Service' && $item->valide_secDg) {
            return back()->withErrors('Cette demande a déjà été traitée par le SecDG et ne peut plus être supprimée.');
        }

        $anneeId = $item->annee_id;
        $item->delete();
        $this->historique('Suppression de la demande de congé #' . $id, $anneeId);
        return back()->with('success', 'Demande de congé supprimée avec succès.');
    }
    public function valider_demande_conge(Request $request, $id)
    {
        $conge = demandes_conge::find($id);
        $data = $request->validate([
            'statut' => 'nullable|string',
            'valide_national' => 'nullable|boolean',
            'valide_secDg' => 'nullable|boolean',
            'valide_serv' => 'nullable|boolean',
        ]);

        if (!$conge) {
            return back()->withErrors('Congé non trouvé.');
        }
        try {
            $conge->update($data);
            return back()->with('success', 'Congé validé avec succès.');
        } catch (\Exception $e) {
            return back()->withErrors('Erreur lors de la validation : ' . $e->getMessage());
        }

        return back()->with('success', 'Congé validé avec succès.');
    }

    public function validerParChefService(Request $request, $id)
    {
        abort_unless(Auth::user()?->role === 'Chef-Service', 403);

        $demande = demandes_conge::findOrFail($id);

        if ($demande->valide_secDg) {
            return back()->withErrors('Cette demande a déjà été traitée par le SecDG et ne peut plus être modifiée.');
        }

        if ($demande->statut !== 'soumise') {
            return back()->withErrors('Cette demande n’est plus en attente de traitement.');
        }

        $data = $request->validate([
            'valide_serv' => ['required', 'boolean'],
            'commentaire_validation' => ['nullable', 'string', 'max:5000'],
        ]);

        $demande->update([
            'valide_serv' => (bool) $data['valide_serv'],
            'commentaire_validation' => $data['commentaire_validation'] ?? $demande->commentaire_validation,
        ]);

        $this->historique(
            ($demande->valide_serv ? 'Validation' : 'Rejet') . ' de la demande de congé #' . $demande->id . ' par le Chef Service',
            $demande->annee_id,
        );

        return back()->with('success', $demande->valide_serv
            ? 'Demande validée par le Chef Service.'
            : 'Demande rejetée par le Chef Service.');
    }

    public function validerParSecDg(Request $request, $id)
    {
        abort_unless(Auth::user()?->role === 'SecDG', 403);

        $demande = demandes_conge::findOrFail($id);

        if (!$demande->valide_serv) {
            return back()->withErrors('Cette demande n’a pas encore été validée par le Chef Service.');
        }

        $data = $request->validate([
            'valide_secDg' => ['required', 'boolean'],
            'commentaire_validation' => ['nullable', 'string', 'max:5000'],
        ]);

        $demande->update([
            'valide_secDg' => (bool) $data['valide_secDg'],
            'commentaire_validation' => $data['commentaire_validation'] ?? $demande->commentaire_validation,
        ]);

        $this->historique(
            ($demande->valide_secDg ? 'Validation' : 'Rejet') . ' niveau SecDG de la demande #' . $demande->id,
            $demande->annee_id,
        );

        return back()->with('success', 'Décision SecDG enregistrée. La validation nationale reste à effectuer.');
    }

    public function validerNationalement(Request $request, $id)
    {
        abort_unless(Auth::user()?->role === 'SecDG', 403);

        $demande = demandes_conge::findOrFail($id);

        if (!$demande->valide_serv || !$demande->valide_secDg) {
            return back()->withErrors('La demande doit être validée par le Chef Service et le SecDG avant la validation nationale.');
        }

        $data = $request->validate([
            'valide_national' => ['required', 'boolean'],
            'statut' => ['nullable', 'in:validee,refusee'],
            'commentaire_validation' => ['nullable', 'string', 'max:5000'],
        ]);

        $demande->update([
            'valide_national' => $data['statut'] === 'validee' && (bool) $data['valide_national'],
            'statut' => $data['statut'],
            'date_validation' => now(),
            'valide_par' => Auth::id(),
            'commentaire_validation' => $data['commentaire_validation'] ?? $demande->commentaire_validation,
        ]);

        $this->historique('Validation nationale de la demande #' . $demande->id, $demande->annee_id);

        return back()->with('success', 'Validation nationale et statut final enregistrés.');
    }

    public function annulerParSecDg($id)
    {
        abort_unless(Auth::user()?->role === 'SecDG', 403);

        $demande = demandes_conge::findOrFail($id);
        $demande->update(['statut' => 'annulee']);
        $this->historique('Annulation de la demande de congé #' . $demande->id . ' par le SecDG', $demande->annee_id);

        return back()->with('success', 'Demande de congé annulée.');
    }

    public function supprimerParSecDg($id)
    {
        abort_unless(Auth::user()?->role === 'SecDG', 403);

        $demande = demandes_conge::findOrFail($id);
        $anneeId = $demande->annee_id;
        $demande->delete();
        $this->historique('Suppression de la demande de congé #' . $id . ' par le SecDG', $anneeId);

        return back()->with('success', 'Demande de congé supprimée.');
    }
}
