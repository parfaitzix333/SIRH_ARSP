<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HandlesCrudHistory;
use App\Models\grade;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    use HandlesCrudHistory;

    private function rules(): array
    {
        return [
            'numero' => ['required', 'integer', 'min:1'],
            'designation' => ['required', 'string', 'max:200'],
        ];
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());
        $item = grade::create($data);
        $this->historique('Création du grade : ' . $item->designation);

        return back()->with('success', 'Grade créé avec succès.');
    }

    public function update(Request $request, $id)
    {
        $item = grade::findOrFail($id);
        $data = $request->validate($this->rules());
        $item->update($data);
        $this->historique('Mise à jour du grade : ' . $item->designation);

        return back()->with('success', 'Grade mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $item = grade::findOrFail($id);

        if ($item->employes()->exists()) {
            return back()->withErrors('Ce grade ne peut pas être supprimé car il est utilisé par un employé.');
        }

        $designation = $item->designation;
        $item->delete();
        $this->historique('Suppression du grade : ' . $designation);

        return back()->with('success', 'Grade supprimé avec succès.');
    }
}
