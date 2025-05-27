<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\CurriculoController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PersonalInfoController;
// use App\Http\Controllers\ProfileController; // Provavelmente não é mais necessário se Breeze cuida do perfil
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Rota inicial (Dashboard ou Home após login)
Route::get('/', [HomeController::class, 'index'])->name('home')->middleware('auth');

// Adicionando a rota nomeada 'dashboard' que o Breeze espera
Route::get('/dashboard', [HomeController::class, 'index'])->middleware(['auth'])->name('dashboard');
// Se você tiver uma view específica para dashboard, poderia ser:
// Route::get('/dashboard', function () {
//     return view('dashboard'); // Certifique-se que resources/views/dashboard.blade.php existe
// })->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware(['auth'])->group(function () {

    // Certificados
    Route::resource('certificates', CertificateController::class);
    Route::get('/certificates/{certificate}/view', [CertificateController::class, 'viewPdf'])->name('certificates.viewPdf');
    Route::get('/certificates/{certificate}/download', [CertificateController::class, 'download'])->name('certificates.download');
    
    // Projetos
    Route::resource('projects', ProjectController::class);

    // Experiências
    Route::resource('experiences', ExperienceController::class);

    // Formações (Educations)
    Route::resource('educations', EducationController::class)->only(['index', 'create', 'store', 'destroy']);

    // Informações Pessoais
    Route::get('/personal-info/edit', [PersonalInfoController::class, 'edit'])->name('personal_info.edit');
    Route::put('/personal-info/update', [PersonalInfoController::class, 'update'])->name('personal_info.update');
    Route::get('/personal-info', [PersonalInfoController::class, 'show'])->name('personal_info.show');

    // Currículo
    Route::get('/curriculo', [CurriculoController::class, 'index'])->name('curriculo.index');
    Route::get('/curriculo/exportar', [CurriculoController::class, 'export'])->name('curriculo.export');

    // Visualizar perfil PÚBLICO de outro usuário
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');

});


// Rotas Públicas
Route::get('/public-projects', [UserController::class, 'publicProjects'])->name('users.public-projects');
Route::get('/explore-projects', function () {
    $projects = \App\Models\Project::where('public', true)->latest()->get();
    return view('projects.explore', compact('projects')); // Certifique-se que a view projects.explore exista
})->name('projects.explore');


// Inclui as rotas de autenticação do Breeze
require __DIR__.'/auth.php';

