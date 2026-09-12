<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HandlesCrudHistory;
use App\Models\contact;
use App\Models\annee;
use App\Models\historique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class contactController extends Controller
{
    use HandlesCrudHistory;

    public function historiqueAction($action, ?int $anneeId = null)
    {
        $anneeId ??= annee::where('statut', 'active')->value('id');
        $ip = request()->ip();

        if (!$anneeId) {
            $anneeId = annee::orderByDesc('annee')->value('id');
        }

        historique::create([
            'action' => $action,
            'ip' => $ip,
            'user_id' => Auth::id(),
            'annee_id' => $anneeId,
        ]);
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'whatsapp' => 'nullable|string|max:50',
            'tel' => 'nullable|string|max:50',
            'adresse' => 'nullable|string',
            'annee_id' => 'required|exists:annees,id',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        try {
            contact::create($data);
            $this->historiqueAction('Ajout d\'un contact : ' . $data['email'], $data['annee_id']);
            return redirect()->back()->with('success', 'contact ajouté');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de l\'ajout du contact : ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'whatsapp' => 'nullable|string|max:50',
            'tel' => 'nullable|string|max:50',
            'adresse' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        try {
            $contact = contact::findOrFail($id);
            $contact->update($data);
            $this->historiqueAction('Mise à jour du contact : ' . $data['email'], $contact->annee_id);
            return redirect()->back()->with('success', 'contact mis à jour');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour : ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $contact = contact::findOrFail($id);
            $anneeId = $contact->annee_id;
            $email = $contact->email;
            $contact->delete();
            $this->historiqueAction('Suppression du contact : ' . $email, $anneeId);
            return redirect()->back()->with('success', 'contact supprimé');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la suppression : ' . $e->getMessage());
        }
    }
}
