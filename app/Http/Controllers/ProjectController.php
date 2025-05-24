<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest; // Alterado de Illuminate\Http\Request
// Se você criar um UpdateProjectRequest, adicione-o aqui também.
// use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use App\Models\User; // Adicionado para type hinting, embora Auth::user() retorne o model User
use Illuminate\Support\Facades\Auth;
// Removido: use Illuminate\Http\Request; (a menos que outros métodos ainda o usem sem FormRequest)

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // O middleware 'auth' na rota já garante que o usuário está logado.
        $user = Auth::user();
        // $projects = Project::where('user_id', $user->id)->get();
        // Melhor usar o relacionamento para carregar os projetos do usuário:
        /** @var \App\Models\User $user */ // Adicione esta linha
        $user = Auth::user();
        $projects = $user->projects()->latest()->get();
        $projects = $user->projects()->latest()->get(); // Adicionado latest() para ordenar

        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Autorização para criar pode ser verificada aqui se necessário,
        // ou no FormRequest se a lógica for simples (como Auth::check()).
        // $this->authorize('create', Project::class); // Exemplo com Policy
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $validatedData = $request->validated();

        /** @var \App\Models\User $user */ // Adicione esta linha
        $user = Auth::user();

        $user->projects()->create([ // Agora use a variável $user type-hinted
            'name' => $validatedData['name'],
            'description' => $validatedData['description'] ?? null,
            'url_project' => $validatedData['url_project'] ?? null,
            'public' => $validatedData['public'],
            'pinned' => false,
        ]);

        return redirect()->route('projects.index')->with('success', 'Projeto salvo com sucesso!');
    }

    /**
     * Display the specified resource.
     * (Adicionando um método show como exemplo, se você não tiver um)
     */
    public function show(Project $project)
    {
        // Autoriza o usuário a ver este projeto específico
        // A Policy ProjectPolicy@view será chamada
        $this->authorize('view', $project);

        return view('projects.show', compact('project')); // Crie esta view se não existir
    }

    /**
     * Show the form for editing the specified resource.
     * (Adicionando um método edit como exemplo)
     */
    public function edit(Project $project)
    {
        // Autoriza o usuário a editar este projeto específico
        // A Policy ProjectPolicy@update será chamada (geralmente a mesma lógica de 'edit')
        $this->authorize('update', $project);

        return view('projects.edit', compact('project')); // Crie esta view se não existir
    }

    /**
     * Update the specified resource in storage.
     * (Adicionando um método update como exemplo)
     */
    // public function update(UpdateProjectRequest $request, Project $project)
    // {
    //     // A autorização (quem pode atualizar) viria do UpdateProjectRequest ou daqui:
    //     $this->authorize('update', $project);
    //
    //     $validatedData = $request->validated();
    //
    //     $project->update([
    //         'name' => $validatedData['name'],
    //         'description' => $validatedData['description'] ?? null,
    //         'url_project' => $validatedData['url_project'] ?? null,
    //         'public' => $validatedData['public'],
    //     ]);
    //
    //     return redirect()->route('projects.index')->with('success', 'Projeto atualizado com sucesso!');
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        // A Policy ProjectPolicy@delete será chamada
        $this->authorize('delete', $project);

        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Projeto deletado com sucesso!');
    }

    // Métodos de pin/unpin comentados foram mantidos como estavam no seu original.
    // Se for implementá-los, também devem ter autorização.
}
