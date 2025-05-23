<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Certificate;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Project;

class HomeController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        $certificates = Certificate::where('user_id', $user->id)->get();
        $projects = Project::where('user_id', $user->id)->get();
        $experiences = Experience::where('user_id', $user->id)->latest()->get();
        $educations = Education::where('user_id', $user->id)->latest()->get();

        // Pega o perfil do usuário (informações pessoais)
        $profile = $user->profile; // Aqui é o relacionamento no model User

        return view('home', compact('certificates', 'projects', 'experiences', 'educations', 'profile', 'user'));
    }
}

