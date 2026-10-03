<?php

namespace App\Http\Controllers;

use App\Services\FaceRecognitionService;
use App\Services\PointageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FaceTemplateController extends Controller
{
    protected FaceRecognitionService $faceApi;
    protected PointageService $pointage;

    public function __construct(FaceRecognitionService $faceApi, PointageService $pointage)
    {
        $this->faceApi = $faceApi;
        $this->pointage = $pointage;
    }

    /**
     * GET /face/health
     * Vérifie que FastAPI est en ligne.
     */
    public function health(): JsonResponse
    {
        try {
            $data = $this->faceApi->health();
            return response()->json([
                'ok'   => true,
                'data' => $data,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'ok'    => false,
                'error' => $e->getMessage(),
            ], 503);
        }
    }

    /**
     * GET /face/employees
     * Liste les employés enrôlés.
     */
    public function employees(): JsonResponse
    {
        try {
            $data = $this->faceApi->listEmployees();
            return response()->json([
                'ok'   => true,
                'data' => $data,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'ok'    => false,
                'error' => $e->getMessage(),
            ], 502);
        }
    }

    /**
     * POST /face/recognize
     * Reconnaît un visage dans l'image uploadée.
     */
    public function recognize(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|file|image|max:10240',
        ]);

        try {
            $result = $this->faceApi->recognize($request->file('file'));

            return response()->json([
                'ok'   => true,
                'data' => $result,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'ok'    => false,
                'error' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * POST /api/face/pointer
     * Identifie l'employé puis enregistre son entrée ou sa sortie.
     */
    public function pointer(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'file' => 'required|file|image|max:10240',
        ]);

        try {
            return response()->json($this->pointage->pointer($validated['file']));
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'ok' => false,
                'reconnu' => false,
                'mouvement' => null,
                'message' => 'Le pointage est temporairement indisponible.',
                'error' => $e->getMessage(),
            ], 503);
        }
    }
}
