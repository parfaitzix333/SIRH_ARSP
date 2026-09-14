<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HandlesCrudHistory;
use App\Models\User;
use App\Models\communique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CommuniqueController extends Controller
{
    use HandlesCrudHistory;

    private function rolesCibles(): array
    {
        return [
            'tous',
            'DG',
            'SecDG',
            'Chef-Division',
            'Chef-Service',
            'Chef-Bureau1',
            'Chef-Bureau2',
            'Chef-Bureau3',
            'Employe',
        ];
    }

    private function normalizeRoleCible(Request $request): void
    {
        $roleCible = $request->input('role_cible');

        if (is_string($roleCible) && strtolower($roleCible) === 'tous') {
            $request->merge(['role_cible' => 'tous']);
        }
    }

    private function rules(bool $hasFile = false): array
    {
        $roles = $this->rolesCibles();

        return [
            'titre' => ['required', 'string', 'max:255'],
            'contenu' => ['required', 'string'],
            'piece_jointe' => [
                $hasFile ? 'required' : 'nullable',
                'file',
                'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,txt,zip',
                'max:20480',
            ],
            'role_cible' => ['required', 'string', 'max:100', 'in:' . implode(',', $roles)],
            'user_id' => ['required', 'exists:users,id'],
            'date_publication' => ['nullable', 'date'],
            'annee_id' => ['required', 'exists:annees,id'],
        ];
    }

    public function store(Request $request)
    {
        $this->normalizeRoleCible($request);
        $request->merge(['user_id' => Auth::id()]);

        $data = $request->validate($this->rules($request->hasFile('piece_jointe')));

        if ($request->hasFile('piece_jointe')) {
            $data['piece_jointe'] = $request->file('piece_jointe')->store('communiques', 'public');
        }

        $item = communique::create($data);
        $this->historique('Création du communiqué : ' . $item->titre, $item->annee_id);
        return back()->with('success', 'Communiqué créé avec succès.');
    }

    public function update(Request $request, $id)
    {
        $item = communique::findOrFail($id);
        $this->normalizeRoleCible($request);
        $request->merge(['user_id' => Auth::id()]);

        $data = $request->validate($this->rules($request->hasFile('piece_jointe')));

        if ($request->hasFile('piece_jointe')) {
            if ($item->piece_jointe && Storage::disk('public')->exists($item->piece_jointe)) {
                Storage::disk('public')->delete($item->piece_jointe);
            }

            $data['piece_jointe'] = $request->file('piece_jointe')->store('communiques', 'public');
        }

        $item->update($data);
        $this->historique('Mise à jour du communiqué : ' . $item->titre, $item->annee_id);
        return back()->with('success', 'Communiqué mis à jour avec succès.');
    }

    public function viewAttachment(string $path)
    {
        $normalizedPath = str_replace('\\', '/', $path);
        $safePath = preg_replace('#(^|/)(\.\.?)(/|$)#', '/', $normalizedPath);

        abort_unless(Storage::disk('public')->exists($safePath), 404);

        return response()->file(
            Storage::disk('public')->path($safePath),
            ['Content-Disposition' => 'inline; filename="' . basename($safePath) . '"'],
        );
    }

    public function destroy($id)
    {
        $item = communique::findOrFail($id);
        $title = $item->titre;
        $anneeId = $item->annee_id;

        if ($item->piece_jointe && Storage::disk('public')->exists($item->piece_jointe)) {
            Storage::disk('public')->delete($item->piece_jointe);
        }

        $item->delete();
        $this->historique('Suppression du communiqué : ' . $title, $anneeId);
        return back()->with('success', 'Communiqué supprimé avec succès.');
    }
}
