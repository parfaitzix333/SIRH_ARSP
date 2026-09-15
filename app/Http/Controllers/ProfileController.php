<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }



    //les profiles
    public function accueil_dg()
    {
        $user = Auth::user();
        return view('profile.accueil_dg', compact('user'));
    }

    public function accueil_secDg()
    {
        $user = Auth::user();
        return view('profile.accueil_secGeneral', compact('user'));
    }

    public function accueil_cs()
    {
        $user = Auth::user();
        return view('profile.accueil_chef_serv', compact('user'));
    }

    public function accueil_cd()
    {
        $user = Auth::user();
        return view('profile.accueil_chef_div', compact('user'));
    }
    public function accueil_cb1()
    {
        $user = Auth::user();
        return view('profile.accueil_bureau1', compact('user'));
    }
    public function accueil_cb2()
    {
        $user = Auth::user();
        return view('profile.accueil_bureau2', compact('user'));
    }
    public function accueil_cb3()
    {
        $user = Auth::user();
        return view('profile.accueil_bureau3', compact('user'));
    }
    public function accueil_employe()
    {
        $user = Auth::user();
        return view('profile.accueil_employe', compact('user'));
    }
}
