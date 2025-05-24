<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\User; // Adicionado para type hinting
// use Illuminate\Http\Request; // Removido
use App\Http\Requests\StoreEducationRequest; // Adicionado
use Illuminate\Support\Facades\Auth;

class EducationController extends Controller
{
    public function __construct()
    {
        // Aplicar middleware de autenticação aqui ou nas rotas
        // $this->middleware('auth');
    }

    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        // A verificação if (!$user) é desnecessária se a rota estiver protegida por middleware 'auth'
        $educations = $user->educations()->latest()->get();

        return view('educations.index', compact('educations'));
    }

    public function create()
    {
        $this->authorize('create', Education::class); // Usando Policy
        return view('educations.create');
    }

    public function store(StoreEducationRequest $request) // Alterado para StoreEducationRequest
    {
        // Autorização e validação já foram feitas pelo StoreEducationRequest.
        $validatedData = $request->validated();

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $user->educations()->create($validatedData);

        return redirect()->route('educations.index')->with('success', 'Formação adicionada!');
    }

    // Adicionar métodos show(Education $education) e edit(Education $education) se necessário,
    // usando $this->authorize('view', $education) e $this->authorize('update', $education) respectivamente.

    public function destroy(Education $education)
    {
        $this->authorize('delete', $education); // Usando Policy

        $education->delete();

        return redirect()->route('educations.index')->with('success', 'Formação removida.');
    }
}
