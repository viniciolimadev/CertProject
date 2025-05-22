<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

// Rota inicial


// Autenticação (login, registro, logout)
Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home')->middleware('auth');

// Grupo protegido por login
Route::middleware(['auth'])->group(function () {

    Route::get('/certificates/{certificate}/view', [CertificateController::class, 'viewPdf'])
        ->middleware('auth')
        ->name('certificates.view');


    Route::get('/certificates', [CertificateController::class, 'index'])->name('certificates.index');

    Route::get('/certificates/create', [CertificateController::class, 'create'])->name('certificates.create');

    Route::post('/certificates', [CertificateController::class, 'store'])->name('certificates.store');

    // Listar projetos do usuário autenticado
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');

    // Formulário de criação
    Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');

    // Armazenar novo projeto
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');

    // Perfil do usuário autenticado
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');

    // Visualizar perfil de outro usuário
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');

    // Projetos (CRUD)
    Route::resource('projects', ProjectController::class);

    // Certificados (CRUD)
    Route::resource('certificates', CertificateController::class);

    // Route::patch('/certificates/{certificate}/pin', [CertificateController::class, 'pin'])->name('certificates.pin');
    // Route::patch('/certificates/{certificate}/unpin', [CertificateController::class, 'unpin'])->name('certificates.unpin');


    // Route::patch('/projects/{project}/pin', [ProjectController::class, 'pin'])->name('projects.pin');
    // Route::patch('/projects/{project}/unpin', [ProjectController::class, 'unpin'])->name('projects.unpin');
});

// Projetos públicos de outros usuários (visível sem login)
Route::get('/public-projects', [UserController::class, 'publicProjects'])->name('users.public-projects');
Route::get('/explore-projects', function () {
    $projects = \App\Models\Project::where('public', true)->get();
    return view('projects.explore', compact('projects'));
})->name('projects.explore');
