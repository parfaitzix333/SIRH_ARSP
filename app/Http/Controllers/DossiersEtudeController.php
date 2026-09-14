<?php

namespace App\Http\Controllers;

use App\Models\dossiers_etude;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DossiersEtudeController extends Controller
{
    private function rules(bool $hasFile = false): array
    {
        return [
            'type_document' => ['required', 'string', 'max:100'],
            'fichier' => [
                $hasFile ? 'required' : 'nullable',
                'file',
                'mimes:pdf,doc,docx,jpg,jpeg,png,webp,xls,xlsx,ppt,pptx,txt,zip',
                'max:20480',
            ],
            'annee_id' => ['required', 'exists:annees,id'],
            'employe_id' => ['required', 'exists:employes,id'],
        ];
    }

    private function storeUploadedFile(Request $request, array $data): array
    {
        if ($request->hasFile('fichier')) {
            $data['fichier'] = $request->file('fichier')->store('dossiers-etude', 'public');
        }

        return $data;
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules($request->hasFile('fichier')));
        $data = $this->storeUploadedFile($request, $data);

        $item = dossiers_etude::create($data);

        return back()->with('success', 'Dossier d’étude créé avec succès.');
    }

    public function update(Request $request, $id)
    {
        $item = dossiers_etude::findOrFail($id);
        $oldFile = $item->fichier;
        $data = $request->validate($this->rules($request->hasFile('fichier')));
        $data = $this->storeUploadedFile($request, $data);

        if (!array_key_exists('fichier', $data)) {
            unset($data['fichier']);
        }

        $item->update($data);

        if (isset($data['fichier']) && $data['fichier'] !== $oldFile) {
            if ($oldFile && Storage::disk('public')->exists($oldFile)) {
                Storage::disk('public')->delete($oldFile);
            }
        }

        return back()->with('success', 'Dossier d’étude mis à jour avec succès.');
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
        $item = dossiers_etude::findOrFail($id);

        if ($item->fichier && Storage::disk('public')->exists($item->fichier)) {
            Storage::disk('public')->delete($item->fichier);
        }

        $item->delete();

        return back()->with('success', 'Dossier d’étude supprimé avec succès.');
    }
}
