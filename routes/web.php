<?php

use App\Http\Controllers\AnneeController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\CommuniqueController;
use App\Http\Controllers\CongeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DemandeCongeController;
use App\Http\Controllers\DisciplineController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\HistoriqueController;
use App\Http\Controllers\MouvementController;
use App\Http\Controllers\PosteController;
use App\Http\Controllers\ProprieteController;
use App\Http\Controllers\ReglementController;
use App\Http\Controllers\SanctionController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\DgController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UtilisateurController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //les profiles
    Route::get('/accueil_dg', [ProfileController::class, 'accueil_dg'])->name('accueil_dg');

    //les pages du directeur general
    Route::get('/les_contacts', [DgController::class, 'les_contacts'])->name('les_contacts');
    Route::put('/switcher-annee', [DgController::class, 'switcher_annee'])->name('switcher_annee');
    Route::get('/les_demandes_conge', [DgController::class, 'les_demandes_conge'])->name('les_demandes_conge');
    Route::get('/les_conges', [DgController::class, 'les_conges'])->name('les_conges');
    Route::get('/les_communiques', [DgController::class, 'les_communiques'])->name('les_communiques');
    Route::get('/les_categories', [DgController::class, 'les_categories'])->name('les_categories');
    Route::get('/les_audits', [DgController::class, 'les_audits'])->name('les_audits');
    Route::get('/les_archives', [DgController::class, 'les_archives'])->name('les_archives');
    Route::get('/les_annees', [DgController::class, 'les_annees'])->name('les_annees');
    Route::get('/les_affectations', [DgController::class, 'les_affectations'])->name('les_affectations');
    Route::get('/historique', [DgController::class, 'historique'])->name('historique');
    Route::delete('/historiques/{id}', [HistoriqueController::class, 'destroy'])->name('historiques.destroy');
    Route::delete('/historiques', [HistoriqueController::class, 'clearAll'])->name('historiques.clearAll');
    Route::delete('/historiques-selectionnes', [HistoriqueController::class, 'deleteSelected'])->name('deleteSelected');
    Route::get('/les_posts', [DgController::class, 'les_posts'])->name('les_posts');
    Route::get('/les_disciplines', [DgController::class, 'les_disciplines'])->name('les_disciplines');
    Route::get('/les_dossiers_etude', [DgController::class, 'les_dossiers_etude'])->name('les_dossiers_etude');
    Route::get('/les_employes', [DgController::class, 'les_employes'])->name('les_employes');
    Route::get('/les_formations', [DgController::class, 'les_formations'])->name('les_formations');
    Route::get('/les_formations_employes', [DgController::class, 'les_formations_employes'])->name('les_formations_employes');
    Route::get('/les_mouvements', [DgController::class, 'les_mouvements'])->name('les_mouvements');
    Route::get('/les_performances', [DgController::class, 'les_performances'])->name('les_performances');
    Route::get('/les_presences', [DgController::class, 'les_presences'])->name('les_presences');
    Route::get('/les_proprietes', [DgController::class, 'les_proprietes'])->name('les_proprietes');
    Route::get('/les_reglements', [DgController::class, 'les_reglements'])->name('les_reglements');
    Route::get('/les_sanctions', [DgController::class, 'les_sanctions'])->name('les_sanctions');
    Route::get('/les_services', [DgController::class, 'les_services'])->name('les_services');
    Route::get('/les_utilisateurs', [DgController::class, 'les_utilisateurs'])->name('les_utilisateurs');

    //Les route resource
    Route::resource('annees', AnneeController::class)
        ->only([
            'index',
            'store',
            'update',
            'destroy'
        ]);
    Route::resource('utilisateurs', UtilisateurController::class)
        ->only([
            'index',
            'store',
            'update',
            'destroy'
        ]);

    Route::resource('contacts', ContactController::class)->only(['store', 'update', 'destroy']);
    Route::resource('communiques', CommuniqueController::class)->only(['store', 'update', 'destroy']);
    Route::resource('audits', AuditController::class)->only(['store', 'update', 'destroy']);
    Route::resource('proprietes', ProprieteController::class)->only(['store', 'update', 'destroy']);
    Route::resource('reglements', ReglementController::class)->only(['store', 'update', 'destroy']);
    Route::resource('formations', FormationController::class)->only(['store', 'update', 'destroy']);
    Route::resource('services', ServiceController::class)->only(['store', 'update', 'destroy']);
    Route::resource('categories', CategorieController::class)->only(['store', 'update', 'destroy']);
    Route::resource('postes', PosteController::class)->only(['store', 'update', 'destroy']);
    Route::resource('sanctions', SanctionController::class)->only(['store', 'update', 'destroy']);
    Route::resource('disciplines', DisciplineController::class)->only(['store', 'update', 'destroy']);
    Route::resource('conges', CongeController::class)->only(['store', 'update', 'destroy']);
    Route::resource('demandes-conges', DemandeCongeController::class)->only(['store', 'update', 'destroy']);
    Route::resource('archives', ArchiveController::class)->only(['store', 'update', 'destroy']);
    Route::resource('mouvements', MouvementController::class)->only(['store', 'update', 'destroy']);
    Route::resource('employes', EmployeController::class)->only(['store', 'update', 'destroy']);
});

require __DIR__ . '/auth.php';
