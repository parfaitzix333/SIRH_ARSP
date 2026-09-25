<?php

namespace App\Http\Controllers;

use App\Models\annee;
use App\Models\conge;
use App\Models\demandes_conge;
use App\Models\employe;
use App\Models\mouvement;
use App\Models\presence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChefBureauController extends Controller
{
    public function profile_cb1()
    {
        $user = Auth::user();
        return view('cb.profile_cb1', compact('user'));
    }
    public function profile_cb2()
    {
        $user = Auth::user();
        return view('cb.profile_cb2', compact('user'));
    }
    public function profile_cb3()
    {
        $user = Auth::user();
        return view('cb.profile_cb3', compact('user'));
    }


    //les pages ordinaires pour le Chef de bureau 
    public function les_employes()
    {
        $user = Auth::user();
        $employes = employe::with(['grade', 'service', 'audits'])
            ->orderBy('nom')
            ->get();
        return view('cb.les_employes', compact('employes', 'user'));
    }

    public function les_mouvements_mois()
    {
        $user = Auth::user();


        $les_mouvements_mois = mouvement::whereMonth('created_at', now()->month)
            ->with('employe')
            ->latest('created_at')
            ->get();
        $employes = employe::orderBy('nom')->get();
        return view('cb/cb2.les_mouvements_mois', compact('les_mouvements_mois', 'user', 'employes'));
    }

    public function les_mouvements_jour()
    {
        $user = Auth::user();
        $les_mouvements_jour = mouvement::whereDay('created_at', now()->day)
            ->with('employe')
            ->latest('created_at')
            ->get();
        $employes = employe::orderBy('nom')->get();

        return view('cb/cb2.les_mouvements_jour', compact('les_mouvements_jour', 'employes', 'user'));
    }

    public function les_presences_jour()
    {
        $user = Auth::user();
        $anneeId = annee::where('statut', 'active')->value('id');
        $les_presences_jour = presence::whereDate('created_at', today())
            ->with('employe')
            ->latest('created_at')
            ->get();
        $employes = employe::orderBy('nom')->get();
        return view('cb.cb1.les_presences_jour', compact('user', 'les_presences_jour', 'employes', 'anneeId'));
    }

    public function les_presences_mois()
    {
        $user = Auth::user();
        $anneeId = annee::where('statut', 'active')->value('id');
        $les_presences_mois = presence::whereMonth('created_at', now()->month)
            ->with('employe')
            ->latest('created_at')
            ->get();
        $employes = employe::orderBy('nom')->get();
        return view('cb.cb1.les_presences_mois', compact('les_presences_mois', 'user', 'employes', 'anneeId'));
    }
}
