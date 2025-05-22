<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Certificate;
use App\Models\Project;

class HomeController extends Controller
{
    /**
     * Exibe a página inicial ou redireciona para login.
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Buscar certificados fixados e não fixados do usuário
        $certificatesPinned = Certificate::where('user_id', $user->id)->where('pinned', true)->get();
        $certificates = Certificate::where('user_id', $user->id)->where('pinned', false)->get();

        // Buscar projetos fixados e não fixados do usuário
        $projectsPinned = Project::where('user_id', $user->id)->where('pinned', true)->get();
        $projects = Project::where('user_id', $user->id)->where('pinned', false)->get();

        return view('home', compact(
            'certificatesPinned', 'certificates',
            'projectsPinned', 'projects'
        ));
    }
}
