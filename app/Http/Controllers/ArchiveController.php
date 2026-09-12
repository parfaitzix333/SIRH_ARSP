<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HandlesCrudHistory;
use App\Models\archive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArchiveController extends Controller
{
    use HandlesCrudHistory;
    private function rules(bool $update = false, bool $hasUpload = false): array
    {
        $fichierRules = $hasUpload
            ? ['file', 'max:10240']
            : ['string', 'max:255'];

        if ($update) {
            array_unshift($fichierRules, 'sometimes', 'nullable');
        } else {
            array_unshift($fichierRules, 'required');
        }

        return [
            'employe_id' => ['nullable', 'exists:employes,id'],
            'type_document' => ['required', 'string', 'max:150'],
            'titre' => ['nullable', 'string', 'max:255'],
            'fichier' => $fichierRules,
            'description' => ['nullable', 'string'],
            'date_archivage' => ['required', 'date'],
            'archive_par' => ['nullable', 'exists:users,id'],
            'annee_id' => ['required', 'exists:annees,id'],
        ];
    }

    private function storeUploadedFile(Request $request, array $data): array
    {
        if ($request->hasFile('fichier')) {
            $data['fichier'] = $request->file('fichier')->store('archives', 'public');
        }

        return $data;
    }
    public function store(Request $request)
    {
        $data = $request->validate($this->rules(false, $request->hasFile('fichier')));
        $data = $this->storeUploadedFile($request, $data);
        $data['archive_par'] = $data['archive_par'] ?? Auth::id();
        $item = archive::create($data);
        $this->historique('Création de l’archive #' . $item->id, $item->annee_id);
        return back()->with('success', 'Archive créée avec succès.');
    }
    public function update(Request $request, $id)
    {
        $item = archive::findOrFail($id);
        $data = $request->validate($this->rules(true, $request->hasFile('fichier')));
        $oldFile = $item->fichier;
        $data = $this->storeUploadedFile($request, $data);
        if (!array_key_exists('fichier', $data)) {
            unset($data['fichier']);
        }
        $item->update($data);

        if (isset($data['fichier']) && $data['fichier'] !== $oldFile) {
            Storage::disk('public')->delete($oldFile);
        }

        $this->historique('Mise à jour de l’archive #' . $item->id, $item->annee_id);
        return back()->with('success', 'Archive mise à jour avec succès.');
    }
    public function destroy($id)
    {
        $item = archive::findOrFail($id);
        $anneeId = $item->annee_id;
        $file = $item->fichier;
        $item->delete();
        Storage::disk('public')->delete($file);
        $this->historique('Suppression de l’archive #' . $id, $anneeId);
        return back()->with('success', 'Archive supprimée avec succès.');
    }
}
