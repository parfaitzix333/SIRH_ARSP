<?php

namespace App\Http\Controllers;

use App\Models\employe;
use App\Models\annee;
use App\Models\historique;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class UtilisateurController extends Controller
{
    private const ROLES = [
        'user',
        'DG',
        'SecDG',
        'Chef-Division',
        'Chef-Service',
        'Chef-Bureau1',
        'Chef-Bureau2',
        'Chef-Bureau3',
        'Employe',
        'Suspendu',
    ];

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


    public function switcher_annee(Request $request)
    {
        $data = $request->validate([
            'annee_id' => 'required|exists:annees,id',
        ]);
        $user = Auth::user();
        $utilisateur = User::find($user->id);
        $utilisateur->annee_id = $data['annee_id'];
        try {
            $utilisateur->save();
            return redirect()->back()->with('success', 'Année d\'exercice changée avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors du changement d\'année : ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        // Logique pour stocker un nouvel utilisateur
        $users = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'matricule' => 'nullable|string|max:255',
            'role' => ['required', 'string', 'in:' . implode(',', self::ROLES)],
            'autorisation' => ['nullable', 'boolean'],
        ]);

        $users['autorisation'] = $request->boolean('autorisation', false);

        $utilisateur = User::create($users);

        $this->historiqueAction('Création d\'un nouvel utilisateur : ' . $users['name']);

        return redirect()->back()->with('success', 'Utilisateur créé avec succès');
    }


    public function update(Request $request, User $utilisateur)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $utilisateur->id,
            'role' => ['required', 'string', 'in:' . implode(',', self::ROLES)],
            'password' => 'nullable|string|min:8',
            'matricule' => 'nullable|string|max:255',
            'autorisation' => ['nullable', 'boolean'],
        ]);

        try {
            $data['autorisation'] = $request->boolean('autorisation', false);

            if (!empty($data['password'])) {
                $data['password'] = bcrypt($data['password']);
            } else {
                unset($data['password']);
            }

            if (empty($data['matricule'])) {
                unset($data['matricule']);
            }

            if (empty($data['role'])) {
                unset($data['role']);
            }

            $estSuspendu = isset($data['role'])
                && $data['role'] === 'Suspendu';

            $utilisateur->update($data);

            if ($estSuspendu) {

                DB::table('sessions')
                    ->where('user_id', $utilisateur->id)
                    ->delete();
            }
            $this->historiqueAction(
                'Mise à jour de l\'utilisateur : ' . $utilisateur->name
            );

            return redirect()
                ->back()
                ->with('success', 'Utilisateur mis à jour avec succès');
        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->withErrors(
                    'Erreur lors de la mise à jour de l\'utilisateur : ' . $e->getMessage()
                );
        }
    }


    public function editpass(Request $request)
    {
        $data = $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'Veuillez saisir votre mot de passe actuel.',
            'password.required' => 'Veuillez saisir un nouveau mot de passe.',
            'password.min' => 'Le nouveau mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du nouveau mot de passe ne correspond pas.',
        ]);

        try {
            $user = User::findOrFail(Auth::id());

            // Vérifier le mot de passe actuel
            if (!Hash::check($data['current_password'], $user->password)) {
                return back()->withErrors([
                    'current_password' => 'Le mot de passe actuel est incorrect.',
                ])->withInput();
            }

            // Enregistrer le nouveau mot de passe
            $user->password = Hash::make($data['password']);
            $user->save();

            return back()->with(
                'success',
                'Mot de passe modifié avec succès !'
            );
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Erreur lors de la modification du mot de passe.',
            ]);
        }
    }

    public function destroy(User $utilisateur)
    {
        // Logique pour supprimer un utilisateur
        try {
            $utilisateur->delete();
            $this->historiqueAction('Suppression de l\'utilisateur : ' . $utilisateur->name);
            return redirect()->back()->with('success', 'Utilisateur supprimé avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la suppression de l\'utilisateur: ' . $e->getMessage());
        }
    }

    public function register_employe()
    {
        return view('auth.register_employe');
    }
    //un employe creer sun compte user en saiaissant son matricule, email et password, si le matricule existe, le user prend le nom de la table employe
    public function nouvel_employe(Request $request)
    {
        // Validation
        $data = $request->validate([
            'matricule' => [
                'required',
                'string',
                'max:255',
                'exists:employes,matricule',
            ],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ], [
            'matricule.required' => 'Le matricule est obligatoire.',
            'matricule.exists' => 'Aucun employe ne possède ce matricule.',

            'email.required' => 'L’adresse email est obligatoire.',
            'email.email' => 'Veuillez fournir une adresse email valide.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',

            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        ]);

        try {

            DB::beginTransaction();

            /*
        |--------------------------------------------------------------------------
        | 1. Rechercher l'employe
        |--------------------------------------------------------------------------
        */

            $employe = employe::where(
                'matricule',
                $data['matricule']
            )->first();

            if (!$employe) {

                DB::rollBack();

                return back()
                    ->withInput()
                    ->withErrors([
                        'matricule' =>
                        'Aucun employe trouvé avec ce matricule.',
                    ]);
            }


            /*
        |--------------------------------------------------------------------------
        | 2. Vérifier si l'employe possède déjà un compte
        |--------------------------------------------------------------------------
        */

            if ($employe->user_id) {

                DB::rollBack();

                return back()
                    ->withInput()
                    ->withErrors([
                        'matricule' =>
                        'Cet employe possède déjà un compte utilisateur.',
                    ]);
            }


            /*
        |--------------------------------------------------------------------------
        | 3. Vérifier si le matricule existe déjà dans users
        |--------------------------------------------------------------------------
        */

            $userExisteDeja = User::where(
                'matricule',
                $data['matricule']
            )->exists();

            if ($userExisteDeja) {

                DB::rollBack();

                return back()
                    ->withInput()
                    ->withErrors([
                        'matricule' =>
                        'Ce matricule est déjà associé à un compte utilisateur.',
                    ]);
            }


            /*
        |--------------------------------------------------------------------------
        | 4. Déterminer l'année scolaire
        |--------------------------------------------------------------------------
        |
        | Si l'inscription est faite par un utilisateur connecté,
        | on récupère son année scolaire.
        |
        */

            $anneeScolaireId = Auth::check()
                ? Auth::user()->anne_scolaire_id
                : null;


            /*
        |--------------------------------------------------------------------------
        | 5. Création du compte utilisateur
        |--------------------------------------------------------------------------
        |
        | Le modèle User possède :
        |
        | 'password' => 'hashed'
        |
        | Laravel s'occupe donc automatiquement du hash.
        |
        */

            $user = User::create([
                'name' => $employe->nom,
                'email' => $data['email'],
                'password' => $data['password'],
                'role' => 'Employe',
                'matricule' => $employe->matricule,
                'anne_scolaire_id' => $anneeScolaireId,
            ]);


            /*
        |--------------------------------------------------------------------------
        | 6. Associer l'employe au compte utilisateur
        |--------------------------------------------------------------------------
        */

            $employe->update([
                'user_id' => $user->id,
            ]);


            /*
        |--------------------------------------------------------------------------
        | 7. Valider la transaction
        |--------------------------------------------------------------------------
        */

            DB::commit();


            /*
        |--------------------------------------------------------------------------
        | 8. Redirection vers la connexion employe
        |--------------------------------------------------------------------------
        */

            return redirect()
                ->route('form_login_employe')
                ->with(
                    'success',
                    'Votre compte employe a été créé avec succès. '
                        . 'Vous pouvez maintenant vous connecter.'
                );
        } catch (\Throwable $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->withErrors([
                    'error' =>
                    'Une erreur est survenue lors de la création du compte. '
                        . 'Veuillez réessayer.',
                ]);
        }
    }

    public function form_employe_register()
    {
        return view('auth.form_employe_register');
    }

    public function form_employe_login()
    {
        return view('auth.login_employe');
    }

    public function employe_register(Request $request)
    {
        $userData = $request->validate([
            'name' => 'nullable|string', // Optionnel car on va utiliser le nom de l'employé
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'matricule' => 'required|string|exists:employes,matricule' // Correction de 'stricg' et ajout exists
        ]);

        // Récupérer l'employé
        $employe = employe::where('matricule', $userData['matricule'])->first();

        if (!$employe) {
            return redirect()->back()->withErrors(['matricule' => 'Ce matricule est inconnu!'])->withInput();
        }

        // Vérifier si l'employé a déjà un compte
        if ($employe->user_id) {
            return redirect()->back()->withErrors(['matricule' => 'Cet employé a déjà un compte utilisateur!'])->withInput();
        }

        // Créer l'utilisateur
        $user = User::create([
            'name' => $employe->nom  ?? '',
            'email' => $userData['email'],
            'password' => Hash::make($userData['password']),
            'matricule' => $userData['matricule'],
            'role' => 'Employe',
        ]);

        // Associer l'utilisateur à l'employé
        $employe->user_id = $user->id;
        $employe->save();

        // Déclencher l'événement d'enregistrement
        event(new Registered($user));

        // Connecter l'utilisateur
        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Compte créé avec succès!');
    }
    //connexion d'un employé avec son matricule
    public function employe_login(Request $request)
    {
        $credentials = $request->validate([
            'matricule' => ['required', 'string', 'max:50'],
            'password' => ['required', 'string', 'min:4'],
        ], [
            'matricule.required' => 'Le matricule est obligatoire.',
            'matricule.string' => 'Le matricule doit être une chaîne de caractères.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit contenir au moins 4 caractères.',
        ]);

        $throttleKey = Str::transliterate(
            Str::lower($credentials['matricule']) . '|' . $request->ip()
        );

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            throw ValidationException::withMessages([
                'matricule' => "Trop de tentatives de connexion. Veuillez réessayer dans {$seconds} secondes.",
            ]);
        }

        $user = User::where('matricule', $credentials['matricule'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            RateLimiter::hit($throttleKey, 60);

            throw ValidationException::withMessages([
                'matricule' => 'Les identifiants fournis sont incorrects.',
            ]);
        }

        if (isset($user->role) && $user->role !== 'Employe') {
            throw ValidationException::withMessages([
                'matricule' => 'Ce compte n\'est pas autorisé à se connecter comme employé.',
            ]);
        }

        Auth::login($user, $request->boolean('remember'));
        RateLimiter::clear($throttleKey);
        $request->session()->regenerate();

        return redirect()->intended(route('accueil_employe'))
            ->with('success', 'Bienvenue ' . ($user->name ?? 'employé') . ' !');
    }
}
