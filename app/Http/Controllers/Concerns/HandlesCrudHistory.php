<?php

namespace App\Http\Controllers\Concerns;

use App\Models\annee;
use App\Models\historique;
use Illuminate\Support\Facades\Auth;

trait HandlesCrudHistory
{
    protected function resolveAnneeId(?int $anneeId = null): ?int
    {
        return $anneeId
            ?? Auth::user()?->annee_id
            ?? annee::where('statut', 'active')->value('id')
            ?? annee::orderByDesc('annee')->value('id');
    }

    protected function historique(string $action, ?int $anneeId = null): void
    {
        $resolvedAnneeId = $this->resolveAnneeId($anneeId);
        $ip = request()->ip();

        if ($resolvedAnneeId) {
            historique::create([
                'action' => $action,
                'user_id' => Auth::id(),
                'ip' => $ip,
                'annee_id' => $resolvedAnneeId,
            ]);
        }
    }
}
