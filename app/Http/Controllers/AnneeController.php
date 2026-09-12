<?php

namespace App\Http\Controllers;

use App\Models\annee;
use App\Models\historique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AnneeController extends Controller
{
    /**
     * Enregistrer une action dans l'historique
     */
    public function historiqueAction($action, ?int $anneeId = null)
    {
        $anneeId ??= annee::where('statut', 'active')->value('id');

        if (!$anneeId) {
            $anneeId = annee::orderByDesc('annee')->value('id');
        }

        historique::create([
            'action' => $action,
            'user_id' => Auth::id(),
            'annee_id' => $anneeId,
        ]);
    }


    /**
     * Afficher la liste des années
     */
    public function index()
    {
        try {

            $user = Auth::user();

            $les_annees = annee::orderBy('annee', 'desc')->get();

            return view(
                'annees.index',
                compact('les_annees', 'user')
            );
        } catch (\Exception $e) {

            Log::error(
                'Erreur chargement années : ' . $e->getMessage()
            );

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Erreur lors du chargement des années.'
                );
        }
    }


    /**
     * Enregistrer une nouvelle année
     */
    public function store(Request $request)
    {
        $data = $request->validate([

            'annee' => [
                'required',
                'integer',
                'digits:4',
                'unique:annees,annee'
            ],

            'statut' => [
                'nullable',
                'in:active,inactive'
            ]

        ], [

            'annee.required' =>
            "L'année est obligatoire.",

            'annee.integer' =>
            "L'année doit être un nombre.",

            'annee.digits' =>
            "L'année doit contenir 4 chiffres.",

            'annee.unique' =>
            "Cette année existe déjà.",

            'statut.in' =>
            "Le statut sélectionné est invalide."
        ]);


        try {

            /*
             * Si aucun statut n'est fourni,
             * l'année sera inactive par défaut.
             */
            if (
                !isset($data['statut']) ||
                empty($data['statut'])
            ) {

                $data['statut'] = 'inactive';
            }


            /*
             * Si cette nouvelle année est activée,
             * on désactive l'année actuellement active.
             */
            if ($data['statut'] === 'active') {

                Annee::where('statut', 'active')
                    ->update([
                        'statut' => 'inactive'
                    ]);
            }


            $annee = Annee::create($data);


            $this->historiqueAction(
                'Création d\'une année : ' . $data['annee'],
                $annee->statut === 'active'
                    ? $annee->id
                    : null
            );


            return redirect()
                ->back()
                ->with(
                    'success',
                    'Année créée avec succès.'
                );
        } catch (\Exception $e) {

            Log::error(
                'Erreur création année : ' .
                    $e->getMessage()
            );

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Erreur lors de la création : ' .
                        $e->getMessage()
                );
        }
    }


    /**
     * Modifier une année
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([

            'annee' => [
                'required',
                'integer',
                'digits:4',
                'unique:annees,annee,' . $id
            ],

            'statut' => [
                'required',
                'in:active,inactive'
            ]

        ], [

            'annee.required' =>
            "L'année est obligatoire.",

            'annee.integer' =>
            "L'année doit être un nombre.",

            'annee.digits' =>
            "L'année doit contenir 4 chiffres.",

            'annee.unique' =>
            "Cette année existe déjà.",

            'statut.required' =>
            "Le statut est obligatoire.",

            'statut.in' =>
            "Le statut sélectionné est invalide."
        ]);


        try {

            $annee = Annee::findOrFail($id);


            /*
             * Vérifier s'il existe déjà
             * une autre année active.
             */
            $anneeActive = Annee::where(
                'statut',
                'active'
            )->first();


            /*
             * Si une autre année est déjà active,
             * on empêche l'activation de celle-ci.
             */
            if (
                $anneeActive &&
                $data['statut'] === 'active' &&
                $anneeActive->id !== $annee->id
            ) {

                return redirect()
                    ->back()
                    ->with(
                        'error',
                        'Il y a déjà une année active. ' .
                            'Veuillez désactiver l\'année actuelle ' .
                            'avant d\'en activer une nouvelle.'
                    );
            }


            $annee->annee = $data['annee'];
            $annee->statut = $data['statut'];

            $annee->save();


            $this->historiqueAction(
                'Mise à jour de l\'année : ' .
                    $data['annee']
            );


            return redirect()
                ->back()
                ->with(
                    'success',
                    'Année mise à jour avec succès.'
                );
        } catch (\Exception $e) {

            Log::error(
                'Erreur mise à jour année : ' .
                    $e->getMessage()
            );

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Erreur lors de la mise à jour : ' .
                        $e->getMessage()
                );
        }
    }


    /**
     * Supprimer une année
     */
    public function destroy($id)
    {
        try {

            $annee = Annee::findOrFail($id);


            /*
             * Empêcher la suppression
             * de l'année actuellement active.
             */
            if ($annee->statut === 'active') {

                return redirect()
                    ->back()
                    ->with(
                        'error',
                        'Impossible de supprimer l\'année active.'
                    );
            }


            $anneeSupprimee = $annee->annee;
            $anneeJournalId = Annee::where('statut', 'active')
                ->where('id', '!=', $annee->id)
                ->value('id');

            $annee->delete();


            if ($anneeJournalId) {
                $this->historiqueAction(
                    'Suppression de l\'année : ' . $anneeSupprimee,
                    $anneeJournalId
                );
            }


            return redirect()
                ->back()
                ->with(
                    'success',
                    'Année supprimée avec succès.'
                );
        } catch (\Exception $e) {

            Log::error(
                'Erreur suppression année : ' .
                    $e->getMessage()
            );

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Erreur lors de la suppression : ' .
                        $e->getMessage()
                );
        }
    }
}
