<?php

namespace App\Http\Controllers;

use App\Services\FaceRecognitionService;
use App\Services\EnrollmentService;
use App\Services\PointageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FaceTemplateController extends Controller
{
    protected FaceRecognitionService $faceApi;
    protected PointageService $pointage;
    protected EnrollmentService $enrollment;

    public function __construct(
        FaceRecognitionService $faceApi,
        PointageService $pointage,
        EnrollmentService $enrollment
    ) {
        $this->faceApi = $faceApi;
        $this->pointage = $pointage;
        $this->enrollment = $enrollment;
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
            'file' => 'required|file|image|max:15360',
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
            'file' => 'required|file|image|max:15360',
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

    /**
     * POST /api/face/enroll
     * Enrôle un employé à partir de cinq images.
     */
    public function enroll(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'employe_id' => ['required', 'integer', 'exists:employes,id'],
            'files' => ['required', 'array', 'size:5'],
            'files.*' => ['required', 'file', 'image', 'mimes:jpg,jpeg,png', 'max:15360'],
        ]);

        try {
            $data = $this->enrollment->enroll((int) $validated['employe_id'], $validated['files']);

            return response()->json([
                'ok' => true,
                'data' => $data,
            ]);
        } catch (\Throwable $e) {
            report($e);
            $status = in_array($e->getCode(), [400, 404, 422], true) ? $e->getCode() : 502;

            return response()->json([
                'ok' => false,
                'error' => $e->getMessage(),
            ], $status);
        }
    }
}
