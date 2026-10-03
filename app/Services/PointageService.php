<?php

namespace App\Services;

use App\Models\annee;
use App\Models\employe;
use App\Models\presence;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class PointageService
{
    public function __construct(private FaceRecognitionService $faceApi)
    {
    }

    public function pointer(UploadedFile $file): array
    {
        $recognition = $this->faceApi->recognize($file);
        $employeeId = (int) ($recognition['employe_id'] ?? -1);
        $recognized = (bool) ($recognition['reconnu'] ?? false) && $employeeId > 0;
        $score = isset($recognition['score']) ? round((float) $recognition['score'], 5) : null;

        if (!$recognized) {
            return [
                'ok' => true,
                'reconnu' => false,
                'employe_id' => $employeeId,
                'nom' => $recognition['nom'] ?? 'INCONNU',
                'matricule' => $recognition['matricule'] ?? '',
                'score' => $score,
                'mouvement' => null,
                'heure' => null,
                'message' => 'INCONNU',
            ];
        }

        return DB::transaction(function () use ($recognition, $employeeId, $score): array {
            $employee = employe::query()->lockForUpdate()->find($employeeId);
            if (!$employee) {
                throw new RuntimeException('Employé reconnu absent de la base ARSP.');
            }

            $activeYear = annee::query()->where('statut', 'active')->lockForUpdate()->first();
            if (!$activeYear) {
                throw new RuntimeException('Aucune année active n’est configurée.');
            }

            $now = now();
            $today = $now->toDateString();
            $presenceQuery = presence::query()
                ->where('employe_id', $employeeId)
                ->where('DATE', $today)
                ->where('annee_id', $activeYear->id);

            $lastPresence = (clone $presenceQuery)
                ->orderByDesc('heure')
                ->orderByDesc('id')
                ->first();

            if ($lastPresence) {
                $lastAt = Carbon::parse($lastPresence->DATE->format('Y-m-d') . ' ' . $lastPresence->heure);
                $elapsedSeconds = (int) $lastAt->diffInSeconds($now);

                if ($elapsedSeconds < 30) {
                    $remaining = 30 - $elapsedSeconds;

                    return $this->result($recognition, $employeeId, $score, null,
                        "Veuillez patienter {$remaining} seconde(s) avant le prochain pointage.",
                        $lastPresence->heure, true, $remaining);
                }
            }

            $hasEntry = (clone $presenceQuery)->where('mouvement', 'entree')->exists();
            $hasExit = (clone $presenceQuery)->where('mouvement', 'sortie')->exists();

            if ($hasEntry && $hasExit) {
                return $this->result($recognition, $employeeId, $score, null,
                    'Déjà pointé aujourd’hui (entrée et sortie enregistrées).', $lastPresence?->heure, true);
            }

            $movement = $hasEntry ? 'sortie' : 'entree';
            $time = $now->format('H:i:s');

            presence::query()->create([
                'employe_id' => $employeeId,
                'DATE' => $today,
                'heure' => $time,
                'mouvement' => $movement,
                'score_reconnaissance' => $score,
                'annee_id' => $activeYear->id,
            ]);

            return $this->result($recognition, $employeeId, $score, $movement,
                strtoupper($movement) . ' enregistrée à ' . $time . '.', $time, true);
        });
    }

    private function result(
        array $recognition,
        int $employeeId,
        ?float $score,
        ?string $movement,
        string $message,
        ?string $time,
        bool $recognized,
        ?int $cooldownRemaining = null
    ): array {
        return [
            'ok' => true,
            'reconnu' => $recognized,
            'employe_id' => $employeeId,
            'nom' => $recognition['nom'] ?? '',
            'matricule' => $recognition['matricule'] ?? '',
            'score' => $score,
            'mouvement' => $movement,
            'heure' => $time,
            'message' => $message,
            'cooldown' => $cooldownRemaining !== null,
            'cooldown_restant' => $cooldownRemaining,
        ];
    }
}
