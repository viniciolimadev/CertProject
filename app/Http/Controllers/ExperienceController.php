<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExperienceRequest; // Adicionado
use App\Models\Experience;
use App\Models\User; // Adicionado para type hinting
use Illuminate\Support\Facades\Auth;
// Remova Illuminate\Http\Request se não for mais usado por outros métodos

class ExperienceController extends Controller
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
        $experiences = $user->experiences()->latest()->get();

        return view('experiences.index', compact('experiences'));
    }

    public function create()
    {
        $this->authorize('create', Experience::class); // Usando Policy
        return view('experiences.create');
    }

    public function store(StoreExperienceRequest $request) // Alterado para StoreExperienceRequest
    {
        // Autorização e validação já foram feitas pelo StoreExperienceRequest.
        $validatedData = $request->validated();

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $user->experiences()->create($validatedData);

        return redirect()->route('experiences.index')->with('success', 'Experiência adicionada com sucesso!');
    }

    // Adicionar métodos show(Experience $experience) e edit(Experience $experience) se necessário,
    // usando $this->authorize('view', $experience) e $this->authorize('update', $experience) respectivamente.

    public function destroy(Experience $experience)
    {
        $this->authorize('delete', $experience); // Usando Policy

        $experience->delete();

        return redirect()->route('experiences.index')->with('success', 'Experiência removida com sucesso!');
    }
}
