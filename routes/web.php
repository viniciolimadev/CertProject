<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\CurriculoController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PersonalInfoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


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
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');

    Route::delete('/certificates/{certificate}', [CertificateController::class, 'destroy'])->name('certificates.destroy');

    Route::resource('experiences', ExperienceController::class)->middleware('auth');

    Route::middleware(['auth'])->group(function () {
    Route::resource('educations', EducationController::class)->only(['index', 'create', 'store', 'destroy']);

    Route::get('/curriculo', [App\Http\Controllers\CurriculoController::class, 'index'])->name('curriculo.index');
    
        
      Route::get('/personal-info/edit', [PersonalInfoController::class, 'edit'])->name('personal_info.edit');
    Route::put('/personal-info/update', [PersonalInfoController::class, 'update'])->name('personal_info.update');
   Route::get('/curriculo/exportar', [CurriculoController::class, 'export'])->name('curriculo.export');
});


// });


//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy'); // <- Esta linha adiciona a rota destroy
//         Route::get('/dashboard', function () {
//     return view('dashboard');

//         // Rotas de autenticação com verificação
// Auth::routes(['verify' => true]);

// // Rota para mostrar aviso de verificação
// Route::get('/email/verify', function () {
//     return view('auth.verify-email');
// })->middleware('auth')->name('verification.notice');

// // Rota para envio do e-mail de verificação
// Route::post('/email/verification-notification', function (Request $request) {
//     $request->user()->sendEmailVerificationNotification();

//     return back()->with('message', 'Link de verificação enviado!');
// })->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// // Rota para processar o clique no link de verificação
// Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
//     $request->fulfill();

//     return redirect('/home');
// })->middleware(['auth', 'signed'])->name('verification.verify');
 
});



// Projetos públicos de outros usuários (visível sem login)
Route::get('/public-projects', [UserController::class, 'publicProjects'])->name('users.public-projects');
Route::get('/explore-projects', function () {
    $projects = \App\Models\Project::where('public', true)->get();
    return view('projects.explore', compact('projects'));
})->name('projects.explore');
