<?php

use App\Http\Controllers\FaceTemplateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//les route pour l'API FastAPI (SANS middleware auth)
Route::prefix('face')->group(function () {
    Route::get('/health',     [FaceTemplateController::class, 'health']);
    Route::get('/employees',  [FaceTemplateController::class, 'employees']);
    Route::post('/recognize', [FaceTemplateController::class, 'recognize']);
});
