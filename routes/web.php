<?php

use App\Http\Controllers\AnneeController;
use App\Http\Controllers\AffectationController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ChefDivController;
use App\Http\Controllers\ChefServController;
use App\Http\Controllers\CommuniqueController;
use App\Http\Controllers\CongeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DemandeCongeController;
use App\Http\Controllers\DisciplineController;
use App\Http\Controllers\DossiersEtudeController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\FormationEmployeController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\HistoriqueController;
use App\Http\Controllers\MouvementController;
use App\Http\Controllers\PerformanceController;
use App\Http\Controllers\PosteController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\ProprieteController;
use App\Http\Controllers\ReglementController;
use App\Http\Controllers\SanctionController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\DgController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SecDgController;
use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\InterimeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/form_employe_register', [UtilisateurController::class, 'form_employe_register'])->name('form_employe_register');
Route::get('/form_employe_login', [UtilisateurController::class, 'form_employe_login'])->name('form_employe_login');
Route::post('/employe_register', [UtilisateurController::class, 'employe_register'])->name('employe_register');
Route::post('/employe_login', [UtilisateurController::class, 'employe_login'])->name('employe_login');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //les profiles
    Route::get('/accueil_dg', [ProfileController::class, 'accueil_dg'])->name('accueil_dg');
    Route::get('/accueil_secDg', [ProfileController::class, 'accueil_secDg'])->name('accueil_secDg');
    Route::get('/accueil_cs', [ProfileController::class, 'accueil_cs'])->name('accueil_cs');
    Route::get('/accueil_employe', [ProfileController::class, 'accueil_employe'])->name('accueil_employe');
    Route::get('/accueil_cd', [ProfileController::class, 'accueil_cd'])->name('accueil_cd');
    Route::get('/accueil_cb1', [ProfileController::class, 'accueil_cb1'])->name('accueil_cb1');
    Route::get('/accueil_cb2', [ProfileController::class, 'accueil_cb2'])->name('accueil_cb2');
    Route::get('/accueil_cb3', [ProfileController::class, 'accueil_cb3'])->name('accueil_cb3');

    //=====================================================================





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
    Route::get('/les_dossiers_etudes', [DgController::class, 'les_dossiers_etudes'])->name('les_dossiers_etudes');
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
    Route::get('/les_interims', [DgController::class, 'les_interims'])->name('les_interims');
    Route::get('/etat_general_employes/{id_emp}', [DgController::class, 'etat_general_employes'])->name('etat_general_employes');
    Route::get('/fiche_de_demande_conge_dg/{id}', [DgController::class, 'fiche_de_demande_conge'])->name('fiche_de_demande_conge_dg');
    //=======================================================




    //les pages du chef de division
    Route::get('/les_contacts_CD', [ChefDivController::class, 'les_contacts'])->name('les_contacts_CD');
    Route::put('/switcher-annee', [ChefDivController::class, 'switcher_annee'])->name('switcher_annee');
    Route::get('/les_demandes_conge_CD', [ChefDivController::class, 'les_demandes_conge'])->name('les_demandes_conge_CD');
    Route::put('/demandes-conges/{id}/valider-secdg', [DemandeCongeController::class, 'validerParSecDg'])
        ->name('valider_conge_secdg');
    Route::put('/demandes-conges/{id}/valider-nationalement', [DemandeCongeController::class, 'validerNationalement'])
        ->name('valider_conge_national');
    Route::put('/demandes-conges/{id}/annuler-secdg', [DemandeCongeController::class, 'annulerParSecDg'])
        ->name('annuler_conge_secdg');
    Route::delete('/demandes-conges/{id}/supprimer-secdg', [DemandeCongeController::class, 'supprimerParSecDg'])
        ->name('supprimer_conge_secdg');
    Route::get('/les_conges_CD', [ChefDivController::class, 'les_conges'])->name('les_conges_CD');
    Route::get('/les_communiques_CD', [ChefDivController::class, 'les_communiques'])->name('les_communiques_CD');
    Route::get('/les_categories_CD', [ChefDivController::class, 'les_categories'])->name('les_categories_CD');
    Route::get('/les_audits_CD', [ChefDivController::class, 'les_audits'])->name('les_audits_CD');
    Route::get('/les_archives_CD', [ChefDivController::class, 'les_archives'])->name('les_archives_CD');
    Route::get('/les_annees_CD', [ChefDivController::class, 'les_annees'])->name('les_annees_CD');
    Route::get('/les_affectations_CD', [ChefDivController::class, 'les_affectations'])->name('les_affectations_CD');
    Route::get('/historique_CD', [ChefDivController::class, 'historique'])->name('historique_CD');
    Route::delete('/historiques/{id}', [HistoriqueController::class, 'destroy'])->name('historiques.destroy');
    Route::delete('/historiques', [HistoriqueController::class, 'clearAll'])->name('historiques.clearAll');
    Route::delete('/historiques-selectionnes', [HistoriqueController::class, 'deleteSelected'])->name('deleteSelected');
    Route::get('/les_posts_CD', [ChefDivController::class, 'les_posts'])->name('les_posts_CD');
    Route::get('/les_disciplines_CD', [ChefDivController::class, 'les_disciplines'])->name('les_disciplines_CD');
    Route::get('/les_dossiers_etude_CD', [ChefDivController::class, 'les_dossiers_etude'])->name('les_dossiers_etude_CD');
    Route::get('/les_dossiers_etudes_CD', [ChefDivController::class, 'les_dossiers_etudes'])->name('les_dossiers_etudes_CD');
    Route::get('/les_employes_CD', [ChefDivController::class, 'les_employes'])->name('les_employes_CD');
    Route::get('/les_formations_CD', [ChefDivController::class, 'les_formations'])->name('les_formations_CD');
    Route::get('/les_formations_employes_CD', [ChefDivController::class, 'les_formations_employes'])->name('les_formations_employes_CD');
    Route::get('/les_mouvements_CD', [ChefDivController::class, 'les_mouvements'])->name('les_mouvements_CD');
    Route::get('/les_performances_CD', [ChefDivController::class, 'les_performances'])->name('les_performances_CD');
    Route::get('/les_presences_CD', [ChefDivController::class, 'les_presences'])->name('les_presences_CD');
    Route::get('/les_proprietes_CD', [ChefDivController::class, 'les_proprietes'])->name('les_proprietes_CD');
    Route::get('/les_reglements_CD', [ChefDivController::class, 'les_reglements'])->name('les_reglements_CD');
    Route::get('/les_sanctions_CD', [ChefDivController::class, 'les_sanctions'])->name('les_sanctions_CD');
    Route::get('/les_services_CD', [ChefDivController::class, 'les_services'])->name('les_services_CD');
    Route::get('/les_utilisateurs_CD', [ChefDivController::class, 'les_utilisateurs'])->name('les_utilisateurs_CD');
    Route::get('/fiche_de_demande_conge_cd/{id}', [ChefDivController::class, 'fiche_de_demande_conge'])->name('fiche_de_demande_conge_cd');
    Route::get('/les_grades_CD', [ChefDivController::class, 'les_grades'])->name('les_grades_CD');
    //========================================================


    //les pages du secretaire generale
    Route::get('/les_contacts_SG', [SecDgController::class, 'les_contacts'])->name('les_contacts_SG');
    Route::put('/switcher-annee', [SecDgController::class, 'switcher_annee'])->name('switcher_annee');
    Route::get('/les_demandes_conge_SG', [SecDgController::class, 'les_demandes_conge'])->name('les_demandes_conge_SG');
    Route::put('/demandes-conges/{id}/valider-secdg', [DemandeCongeController::class, 'validerParSecDg'])
        ->name('valider_conge_secdg');
    Route::put('/demandes-conges/{id}/valider-nationalement', [DemandeCongeController::class, 'validerNationalement'])
        ->name('valider_conge_national');
    Route::put('/demandes-conges/{id}/annuler-secdg', [DemandeCongeController::class, 'annulerParSecDg'])
        ->name('annuler_conge_secdg');
    Route::delete('/demandes-conges/{id}/supprimer-secdg', [DemandeCongeController::class, 'supprimerParSecDg'])
        ->name('supprimer_conge_secdg');
    Route::get('/les_conges_SG', [SecDgController::class, 'les_conges'])->name('les_conges_SG');
    Route::get('/les_communiques_SG', [SecDgController::class, 'les_communiques'])->name('les_communiques_SG');
    Route::get('/les_categories_SG', [SecDgController::class, 'les_categories'])->name('les_categories_SG');
    Route::get('/les_audits_SG', [SecDgController::class, 'les_audits'])->name('les_audits_SG');
    Route::get('/les_archives_SG', [SecDgController::class, 'les_archives'])->name('les_archives_SG');
    Route::get('/les_annees_SG', [SecDgController::class, 'les_annees'])->name('les_annees_SG');
    Route::get('/les_affectations_SG', [SecDgController::class, 'les_affectations'])->name('les_affectations_SG');
    Route::get('/historique_SG', [SecDgController::class, 'historique'])->name('historique_SG');
    Route::delete('/historiques/{id}', [HistoriqueController::class, 'destroy'])->name('historiques.destroy');
    Route::delete('/historiques', [HistoriqueController::class, 'clearAll'])->name('historiques.clearAll');
    Route::delete('/historiques-selectionnes', [HistoriqueController::class, 'deleteSelected'])->name('deleteSelected');
    Route::get('/les_posts_SG', [SecDgController::class, 'les_posts'])->name('les_posts_SG');
    Route::get('/les_disciplines_SG', [SecDgController::class, 'les_disciplines'])->name('les_disciplines_SG');
    Route::get('/les_dossiers_etude_SG', [SecDgController::class, 'les_dossiers_etude'])->name('les_dossiers_etude_SG');
    Route::get('/les_dossiers_etudes_SG', [SecDgController::class, 'les_dossiers_etudes'])->name('les_dossiers_etudes_SG');
    Route::get('/les_employes_SG', [SecDgController::class, 'les_employes'])->name('les_employes_SG');
    Route::get('/les_formations_SG', [SecDgController::class, 'les_formations'])->name('les_formations_SG');
    Route::get('/les_formations_employes_SG', [SecDgController::class, 'les_formations_employes'])->name('les_formations_employes_SG');
    Route::get('/les_mouvements_SG', [SecDgController::class, 'les_mouvements'])->name('les_mouvements_SG');
    Route::get('/les_performances_SG', [SecDgController::class, 'les_performances'])->name('les_performances_SG');
    Route::get('/les_presences_SG', [SecDgController::class, 'les_presences'])->name('les_presences_SG');
    Route::get('/les_proprietes_SG', [SecDgController::class, 'les_proprietes'])->name('les_proprietes_SG');
    Route::get('/les_reglements_SG', [SecDgController::class, 'les_reglements'])->name('les_reglements_SG');
    Route::get('/les_sanctions_SG', [SecDgController::class, 'les_sanctions'])->name('les_sanctions_SG');
    Route::get('/les_services_SG', [SecDgController::class, 'les_services'])->name('les_services_SG');
    Route::get('/les_utilisateurs_SG', [SecDgController::class, 'les_utilisateurs'])->name('les_utilisateurs_SG');
    Route::get('/les_interims_SG', [SecDgController::class, 'les_interims'])->name('les_interims_SG');
    Route::get('/fiche_de_demande_conge_sg/{id}', [SecDgController::class, 'fiche_de_demande_conge'])->name('fiche_de_demande_conge_sg');
    Route::get('/les_grades_SG', [SecDgController::class, 'les_grades'])->name('les_grades_SG');
    //==========================================================



    //les pages du chef de service
    Route::get('/les_contacts_CS', [ChefServController::class, 'les_contacts'])->name('les_contacts_CS');
    Route::put('/switcher-annee', [ChefServController::class, 'switcher_annee'])->name('switcher_annee');
    Route::get('/les_demandes_conge_CS', [ChefServController::class, 'les_demandes_conge'])->name('les_demandes_conge_CS');
    Route::put('/demandes-conges/{id}/valider-chef-service', [DemandeCongeController::class, 'validerParChefService'])
        ->name('valider_conge');
    Route::get('/les_conges_CS', [ChefServController::class, 'les_conges'])->name('les_conges_CS');
    Route::get('/les_communiques_CS', [ChefServController::class, 'les_communiques'])->name('les_communiques_CS');
    Route::get('/les_categories_CS', [ChefServController::class, 'les_categories'])->name('les_categories_CS');
    Route::get('/les_audits_CS', [ChefServController::class, 'les_audits'])->name('les_audits_CS');
    Route::get('/les_archives_CS', [ChefServController::class, 'les_archives'])->name('les_archives_CS');
    Route::get('/les_annees_CS', [ChefServController::class, 'les_annees'])->name('les_annees_CS');
    Route::get('/les_affectations_CS', [ChefServController::class, 'les_affectations'])->name('les_affectations_CS');
    Route::get('/historique_CS', [ChefServController::class, 'historique'])->name('historique_CS');
    Route::delete('/historiques/{id}', [HistoriqueController::class, 'destroy'])->name('historiques.destroy');
    Route::delete('/historiques', [HistoriqueController::class, 'clearAll'])->name('historiques.clearAll');
    Route::delete('/historiques-selectionnes', [HistoriqueController::class, 'deleteSelected'])->name('deleteSelected');
    Route::get('/les_posts_CS', [ChefServController::class, 'les_posts'])->name('les_posts_CS');
    Route::get('/les_disciplines_CS', [ChefServController::class, 'les_disciplines'])->name('les_disciplines_CS');
    Route::get('/les_dossiers_etude_CS', [ChefServController::class, 'les_dossiers_etude'])->name('les_dossiers_etude_CS');
    Route::get('/les_dossiers_etudes_CS', [ChefServController::class, 'les_dossiers_etudes'])->name('les_dossiers_etudes_CS');
    Route::get('/les_employes_CS', [ChefServController::class, 'les_employes'])->name('les_employes_CS');
    Route::get('/les_formations_CS', [ChefServController::class, 'les_formations'])->name('les_formations_CS');
    Route::get('/les_formations_employes_CS', [ChefServController::class, 'les_formations_employes'])->name('les_formations_employes_CS');
    Route::get('/les_mouvements_CS', [ChefServController::class, 'les_mouvements'])->name('les_mouvements_CS');
    Route::get('/les_performances_CS', [ChefServController::class, 'les_performances'])->name('les_performances_CS');
    Route::get('/les_presences_CS', [ChefServController::class, 'les_presences'])->name('les_presences_CS');
    Route::get('/les_proprietes_CS', [ChefServController::class, 'les_proprietes'])->name('les_proprietes_CS');
    Route::get('/les_reglements_CS', [ChefServController::class, 'les_reglements'])->name('les_reglements_CS');
    Route::get('/les_sanctions_CS', [ChefServController::class, 'les_sanctions'])->name('les_sanctions_CS');
    Route::get('/les_services_CS', [ChefServController::class, 'les_services'])->name('les_services_CS');
    Route::get('/les_utilisateurs_CS', [ChefServController::class, 'les_utilisateurs'])->name('les_utilisateurs_CS');
    Route::get('/les_interims_CS', [ChefServController::class, 'les_interims'])->name('les_interims_CS');

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
    Route::get('/communiques/file/{path}', [CommuniqueController::class, 'viewAttachment'])
        ->where('path', '.*')
        ->name('communiques.file');
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
    Route::resource('grades', GradeController::class)->only(['store', 'update', 'destroy']);
    Route::resource('demandes-conges', DemandeCongeController::class)->only(['store', 'update', 'destroy']);
    Route::get('/archives/file/{path}', [ArchiveController::class, 'viewAttachment'])
        ->where('path', '.*')
        ->name('archives.file');
    Route::resource('archives', ArchiveController::class)->only(['store', 'update', 'destroy']);
    Route::get('/dossiers-etudes/file/{path}', [DossiersEtudeController::class, 'viewAttachment'])
        ->where('path', '.*')
        ->name('dossiers-etudes.file');
    Route::resource('dossiers-etudes', DossiersEtudeController::class)->only(['store', 'update', 'destroy']);
    Route::resource('mouvements', MouvementController::class)->only(['store', 'update', 'destroy']);
    Route::resource('employes', EmployeController::class)->only(['store', 'update', 'destroy']);
    Route::resource('interimes', InterimeController::class)->only(['store', 'update', 'destroy']);
    Route::resource('affectations', AffectationController::class)->only(['store', 'update', 'destroy']);
    Route::get('/formations-employes/file/{path}', [FormationEmployeController::class, 'viewAttachment'])
        ->where('path', '.*')
        ->name('formations-employes.file');
    Route::resource('formations-employes', FormationEmployeController::class)->only(['store', 'update', 'destroy']);
    Route::resource('performances', PerformanceController::class)->only(['store', 'update', 'destroy']);
    Route::resource('presences', PresenceController::class)->only(['store', 'update', 'destroy']);
    //================================================


    //les routes pour employé
    Route::get('/mes_conges', [EmployeController::class, 'mes_conges'])->name('mes_conges');
    Route::post('/mes_conges', [DemandeCongeController::class, 'storeEmploye'])->name('mes_conges.store');
    Route::get('/mes_disciplines', [EmployeController::class, 'mes_disciplines'])->name('mes_disciplines');
    Route::get('/mes_presences', [EmployeController::class, 'mes_presences'])->name('mes_presences');
    Route::get('/mes_communiques', [EmployeController::class, 'mes_communiques'])->name('mes_communiques');
    Route::get('/lecture/{id}', [CommuniqueController::class, 'lecture'])->name('lecture');
    route::get('/mon_autorisation/{employe}', [EmployeController::class, 'mon_autorisation'])->name('mon_autorisation');

    //les affichages communs
});

require __DIR__ . '/auth.php';
