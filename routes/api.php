<?php

use App\Http\Controllers\CertificateController;
use App\Http\Controllers\ProjectController;
use Illuminate\Http\Request; // Adicionado para a rota de usuário autenticado
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Rota padrão do Laravel para obter o usuário autenticado via token
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Suas rotas de API protegidas pelo Sanctum
Route::middleware('auth:sanctum')->group(function () {
    // Rotas de Certificados
    Route::get('/certificates', [CertificateController::class, 'index']);
    Route::post('/certificates', [CertificateController::class, 'store']);
    Route::get('/certificates/{certificate}', [CertificateController::class, 'show']);
    Route::get('/certificates/{certificate}/download', [CertificateController::class, 'download']);

    // Rotas de Projetos
    Route::get('/projects', [ProjectController::class, 'index']);
    Route::post('/projects', [ProjectController::class, 'store']);
    Route::get('/projects/{project}', [ProjectController::class, 'show']);

    // Adicione outras rotas de API que precisam de autenticação aqui
});

// Se você tiver rotas de API que são intencionalmente públicas (não precisam de login),
// defina-as fora do grupo 'auth:sanctum'. Por exemplo:
// Route::get('/public-data', [SomePublicController::class, 'index']);

?>
