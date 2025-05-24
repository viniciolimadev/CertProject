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
// use Illuminate\Foundation\Auth\EmailVerificationRequest; // Não é usado diretamente aqui
// use Illuminate\Support\Facades\Auth; // Não é usado diretamente aqui
// use Illuminate\Http\Request; // Não é usado diretamente aqui

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
// A rota '/' agora aponta para HomeController, que já redireciona para login se não autenticado.
Route::get('/', [HomeController::class, 'index'])->name('home')->middleware('auth');

// Rotas de autenticação geradas pelo Breeze (geralmente incluídas via bootstrap/app.php ou um service provider)
// Se você executou `php artisan breeze:install`, as rotas de auth (login, register, etc.)
// são carregadas a partir de `routes/auth.php`.
// A linha `Auth::routes();` foi removida pois era do laravel/ui.

// Grupo de rotas que exigem autenticação
Route::middleware(['auth'])->group(function () {

    // Dashboard (se você estiver usando a rota padrão do Breeze)
    // Se a sua HomeController@index já é o seu dashboard, a rota '/' acima já o cobre.
    // Se você tem uma view específica para dashboard:
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard'); // A rota 'dashboard' é referenciada pelo Breeze

    // Perfil do usuário (gerenciado pelo Breeze, geralmente em /profile)
    // As rotas de ProfileController (update, delete) são geralmente definidas em routes/auth.php pelo Breeze.
    // Se você tem uma rota customizada para ProfileController, adicione aqui.
    // Ex: Route::get('/profile-custom', [ProfileController::class, 'edit'])->name('profile.custom.edit');

    // Certificados
    // Route::resource já cria: index, create, store, show, edit, update, destroy
    // As rotas manuais para index, create, store, destroy foram removidas pois são cobertas pelo resource.
    Route::resource('certificates', CertificateController::class);
    // Rota customizada para visualizar o PDF do certificado
    Route::get('/certificates/{certificate}/view', [CertificateController::class, 'viewPdf'])->name('certificates.viewPdf'); // Nomeado para evitar conflito com show

    // Projetos
    // As rotas manuais para index, create, store, destroy foram removidas.
    Route::resource('projects', ProjectController::class);
    // Se precisar de rotas adicionais para 'pin/unpin', elas seriam definidas aqui.

    // Experiências
    Route::resource('experiences', ExperienceController::class); // Já tem middleware('auth') do grupo pai

    // Formações (Educations)
    // O ->only([...]) é bom se você não precisa de todas as rotas do resource.
    Route::resource('educations', EducationController::class)->only(['index', 'create', 'store', 'destroy']);

    // Informações Pessoais
    Route::get('/personal-info/edit', [PersonalInfoController::class, 'edit'])->name('personal_info.edit');
    Route::put('/personal-info/update', [PersonalInfoController::class, 'update'])->name('personal_info.update');

    // Currículo
    Route::get('/curriculo', [CurriculoController::class, 'index'])->name('curriculo.index');
    Route::get('/curriculo/exportar', [CurriculoController::class, 'export'])->name('curriculo.export');

    // Visualizar perfil PÚBLICO de outro usuário (se for uma funcionalidade para usuários logados)
    // Se esta rota é para ver o perfil de qualquer usuário (e não apenas o próprio ou públicos),
    // a lógica de autorização deve estar no UserController@show.
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show'); // {id} foi mudado para {user} para route model binding

});


// Rotas Públicas (não exigem login)
// Visualizar projetos públicos de outros usuários
Route::get('/public-projects', [UserController::class, 'publicProjects'])->name('users.public-projects');

// Explorar todos os projetos públicos (outra forma de listar projetos públicos)
Route::get('/explore-projects', function () {
    $projects = \App\Models\Project::where('public', true)->latest()->get(); // Adicionado latest()
    return view('projects.explore', compact('projects')); // Certifique-se que a view projects.explore exista
})->name('projects.explore');


// As rotas de verificação de e-mail e outras rotas de autenticação do Breeze
// são geralmente incluídas automaticamente a partir do arquivo `routes/auth.php`.
// Se não estiverem, você pode requerer o arquivo aqui:
// require __DIR__.'/auth.php'; // Descomente se as rotas do Breeze não estiverem carregando

