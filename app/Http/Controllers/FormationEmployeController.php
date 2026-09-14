<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HandlesCrudHistory;
use App\Models\formation_employe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FormationEmployeController extends Controller
{
    use HandlesCrudHistory;

    private function rules(bool $hasFile = false): array
    {
        return [
            'formation_id' => ['required', 'exists:formations,id'],
            'employe_id' => ['required', 'exists:employes,id'],
            'statut' => ['nullable', 'string', 'max:100'],
            'resultat' => ['nullable', 'string', 'max:100'],
            'certificat' => [
                $hasFile ? 'required' : 'nullable',
                'file',
                'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,webp,txt,zip',
                'max:20480',
            ],
            'annee_id' => ['required', 'exists:annees,id'],
        ];
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules($request->hasFile('certificat')));

        if ($request->hasFile('certificat')) {
            $data['certificat'] = $request->file('certificat')->store('formations-employes', 'public');
        }

        $item = formation_employe::create($data);
        $this->historique('Création de l’inscription à la formation #' . $item->id, $item->annee_id);

        return back()->with('success', 'Formation employé créée avec succès.');
    }

    public function update(Request $request, $id)
    {
        $item = formation_employe::findOrFail($id);
        $data = $request->validate($this->rules($request->hasFile('certificat')));

        if ($request->hasFile('certificat')) {
            if ($item->certificat && Storage::disk('public')->exists($item->certificat)) {
                Storage::disk('public')->delete($item->certificat);
            }

            $data['certificat'] = $request->file('certificat')->store('formations-employes', 'public');
        }

        $item->update($data);
        $this->historique('Mise à jour de la formation employé #' . $item->id, $item->annee_id);

        return back()->with('success', 'Formation employé mise à jour avec succès.');
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
        $item = formation_employe::findOrFail($id);
        $anneeId = $item->annee_id;

        if ($item->certificat && Storage::disk('public')->exists($item->certificat)) {
            Storage::disk('public')->delete($item->certificat);
        }

        $item->delete();
        $this->historique('Suppression de la formation employé #' . $id, $anneeId);

        return back()->with('success', 'Formation employé supprimée avec succès.');
    }
}
