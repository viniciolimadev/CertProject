<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Perfil do usuário autenticado
    public function profile()
    {
        $user = Auth::user();
        $certificates = $user->certificates;
        $projects = $user->projects;

        return view('users.profile', compact('user', 'certificates', 'projects'));
    }

    // Lista de projetos públicos de todos os usuários
    public function publicProjects()
    {
        $users = User::whereHas('projects', function ($query) {
            $query->where('public', true);
        })->with(['projects' => function ($query) {
            $query->where('public', true);
        }])->get();

        return view('users.public-projects', compact('users'));
    }

    // Visualizar perfil de outro usuário com projetos públicos
    public function show($id)
    {
        $user = User::findOrFail($id);
        $projects = $user->projects()->where('public', true)->get();

        return view('users.show', compact('user', 'projects'));
    }
}
