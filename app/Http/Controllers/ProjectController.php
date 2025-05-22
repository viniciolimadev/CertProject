<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->withErrors('Você precisa estar logado para ver seus projetos.');
        }

        // Busca projetos fixados e não fixados do usuário
        // $projectsPinned = Project::where('user_id', $user->id)
        //                           ->where('pinned', true)
        //                           ->get();

        $projects = Project::where('user_id', $user->id)->get();

        // Passa para a view os dois grupos de projetos
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');  // Retorna a view para criar um projeto
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'url_project' => 'nullable|url',
            'public' => 'nullable|boolean',
        ]);

        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->withErrors('Você precisa estar logado para criar um projeto.');
        }

        Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'url_project' => $request->url_project,
            'public' => $request->has('public'),
            'user_id' => $user->id,
            'pinned' => false, // padrão: não fixado ao criar
        ]);

        return redirect()->route('projects.index')->with('success', 'Projeto salvo com sucesso!');
    }

    // Você pode adicionar um método para fixar/desfixar um projeto, algo como:
    // public function togglePin(Project $project)
    // {
    //     $user = Auth::user();

    //     // Verifica se o projeto pertence ao usuário
    //     if ($project->user_id !== $user->id) {
    //         abort(403);
    //     }

    //     $project->pinned = !$project->pinned;
    //     $project->save();

    //     return redirect()->back()->with('success', 'Status de fixação atualizado!');
   
    // }
//     public function pin(Project $project)
// {
//     if ($project->user_id !== Auth::id()) {
//         abort(403);
//     }

//     $project->pinned = true;
//     $project->save();

//     return redirect()->back()->with('success', 'Projeto fixado com sucesso.');
// }

// public function unpin(Project $project)
// {
//     if ($project->user_id !== Auth::id()) {
//         abort(403);
//     }

//     $project->pinned = false;
//     $project->save();

//     return redirect()->back()->with('success', 'Projeto desafixado com sucesso.');
// }
}
