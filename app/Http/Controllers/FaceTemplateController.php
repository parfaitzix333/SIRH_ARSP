<?php

namespace App\Http\Controllers;

use App\Services\FaceRecognitionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FaceTemplateController extends Controller
{
    protected FaceRecognitionService $faceApi;

    public function __construct(FaceRecognitionService $faceApi)
    {
        $this->faceApi = $faceApi;
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
}
