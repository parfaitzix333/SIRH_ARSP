<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class EnrollmentService
{
    public function enroll(int $employeeId, array $files): array
    {
        $baseUrl = rtrim((string) config('services.face_api.url'), '/');
        $timeout = (int) config('services.face_api.timeout', 30);

        if ($baseUrl === '') {
            throw new RuntimeException('L’URL de l’API de reconnaissance faciale n’est pas configurée.');
        }

        $request = Http::timeout($timeout)->acceptJson();

        foreach ($files as $file) {
            if (!$file instanceof UploadedFile || !$file->isValid()) {
                throw new RuntimeException('Un des fichiers reçus est invalide.');
            }

            $contents = file_get_contents($file->getRealPath());
            if ($contents === false) {
                throw new RuntimeException('Impossible de lire une des images envoyées.');
            }

            $request = $request->attach(
                'files',
                $contents,
                $file->getClientOriginalName(),
                ['Content-Type' => $file->getMimeType() ?: 'application/octet-stream']
            );
        }

        $response = $request->post("{$baseUrl}/enroll", [
            'employe_id' => $employeeId,
        ]);

        if ($response->failed()) {
            $detail = $response->json('detail') ?? $response->json('message') ?? $response->body();
            Log::warning('[FaceAPI] Échec de l’enrôlement', [
                'employe_id' => $employeeId,
                'status' => $response->status(),
                'detail' => $detail,
            ]);

            throw new RuntimeException(
                is_string($detail) ? $detail : 'L’API a refusé l’enrôlement.',
                $response->status()
            );
        }

        return $response->json() ?? [];
    }
}
