<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\UploadedFile;

/**
 * Service client pour l'API FastAPI de reconnaissance faciale.
 */
class FaceRecognitionService
{
    protected string $baseUrl;
    protected int $timeout;

    public function __construct()
    {
        $this->baseUrl = config('services.face_api.url');
        $this->timeout = config('services.face_api.timeout', 30);
    }

    /**
     * Vérifie que l'API est en ligne.
     */
    public function health(): array
    {
        $response = Http::timeout($this->timeout)
            ->get("{$this->baseUrl}/health");

        return $this->handleResponse($response);
    }

    /**
     * Liste les employés enrôlés côté FastAPI.
     */
    public function listEmployees(): array
    {
        $response = Http::timeout($this->timeout)
            ->get("{$this->baseUrl}/employees");

        return $this->handleResponse($response);
    }

    /**
     * Reconnaît un visage dans une image uploadée.
     */
    public function recognize(UploadedFile $file): array
    {
        $response = Http::timeout($this->timeout)
            ->attach(
                'file',
                file_get_contents($file->getRealPath()),
                $file->getClientOriginalName()
            )
            ->post("{$this->baseUrl}/recognize");

        return $this->handleResponse($response);
    }

    /**
     * Reconnaît un visage depuis un chemin de fichier local.
     */
    public function recognizeFromPath(string $path): array
    {
        if (!file_exists($path)) {
            throw new \RuntimeException("Fichier introuvable : {$path}");
        }

        $response = Http::timeout($this->timeout)
            ->attach(
                'file',
                file_get_contents($path),
                basename($path)
            )
            ->post("{$this->baseUrl}/recognize");

        return $this->handleResponse($response);
    }

    /**
     * Gère la réponse HTTP et lève une exception si erreur.
     */
    protected function handleResponse($response): array
    {
        if ($response->failed()) {
            $body = $response->json();
            $detail = $body['detail'] ?? $response->body();

            Log::warning('[FaceAPI] Erreur', [
                'status' => $response->status(),
                'detail' => $detail,
            ]);

            throw new \RuntimeException(
                "Erreur API Face (HTTP {$response->status()}) : {$detail}"
            );
        }

        return $response->json();
    }
    
}
