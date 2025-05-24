<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCertificateRequest; // Adicionado
use App\Models\Certificate;
use App\Models\User; // Adicionado para type hinting
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
// Remova Illuminate\Http\Request se não for mais usado diretamente

class CertificateController extends Controller
{
    public function __construct()
    {
        // Aplicar middleware de autenticação a todos os métodos aqui,
        // ou preferencialmente nas definições de rota em routes/web.php
        // Exemplo: $this->middleware('auth');
    }

    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        // A verificação if (!$user) é desnecessária se a rota estiver protegida por middleware 'auth'
        $certificates = $user->certificates()->latest()->get(); // Usando o relacionamento

        return view('certificates.index', compact('certificates'));
    }

    public function viewPdf(Certificate $certificate)
    {
        $this->authorize('view', $certificate); // Utiliza a CertificatePolicy

        // Verifica se o arquivo existe no disco 'public'
        if (!Storage::disk('public')->exists($certificate->file_path)) {
            abort(404, 'Arquivo de certificado não encontrado.');
        }

        // Retorna o arquivo diretamente do storage
        return response()->file(storage_path("app/public/{$certificate->file_path}"));
    }

    public function create()
    {
        // Utiliza a CertificatePolicy para verificar se o usuário pode criar certificados
        $this->authorize('create', Certificate::class);
        return view('certificates.create');
    }

    public function store(StoreCertificateRequest $request) // Alterado para StoreCertificateRequest
    {
        // A autorização (Auth::check()) e a validação já foram feitas pelo StoreCertificateRequest
        $validatedData = $request->validated();

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Salva o arquivo e obtém o caminho
        $path = $request->file('file_path')->store('certificates', 'public');

        // Cria o certificado usando o relacionamento
        $user->certificates()->create([
            'title' => $validatedData['title'],
            'description_certificate' => $validatedData['description_certificate'],
            'file_path' => $path,
            'start_date' => $validatedData['start_date'] ?? null,
            'end_date' => $validatedData['end_date'] ?? null,
            'duration' => $validatedData['duration'] ?? null,
        ]);

        return redirect()->route('certificates.index')->with('success', 'Certificado salvo com sucesso!');
    }

    public function show(Certificate $certificate)
    {
        // Utiliza a CertificatePolicy para verificar se o usuário pode ver este certificado
        $this->authorize('view', $certificate);
        // Considere se você realmente precisa de uma view 'show' separada ou se a 'index' e 'viewPdf' são suficientes.
        // Se for usar, crie a view: resources/views/certificates/show.blade.php
        return view('certificates.show', compact('certificate'));
    }

    public function download(Certificate $certificate)
    {
        // Utiliza a CertificatePolicy para verificar se o usuário pode ver/baixar este certificado
        $this->authorize('view', $certificate); // Ou crie uma ação 'download' na policy

        // Verifica se o arquivo existe e faz o download usando o facade Storage
        if (!Storage::disk('public')->exists($certificate->file_path)) {
            abort(404, 'Arquivo de certificado não encontrado.');
        }
        return Storage::disk('public')->download($certificate->file_path);
    }

    public function destroy(Certificate $certificate)
    {
        // Utiliza a CertificatePolicy para verificar se o usuário pode deletar este certificado
        $this->authorize('delete', $certificate);

        // Deleta o arquivo físico do storage
        if (Storage::disk('public')->exists($certificate->file_path)) {
            Storage::disk('public')->delete($certificate->file_path);
        }

        $certificate->delete();

        return redirect()->route('certificates.index')->with('success', 'Certificado deletado com sucesso!');
    }
}
