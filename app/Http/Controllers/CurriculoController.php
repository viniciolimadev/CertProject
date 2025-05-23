<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Certificate;
use App\Models\Project;
use App\Models\Experience;
use App\Models\Education;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\View;

class CurriculoController extends Controller
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

        return view('curriculo.index', compact('certificates', 'projects', 'experiences', 'educations', 'profile', 'user'));
    }
    public function export()
    {
        $user = Auth::user();
        $profile = $user->profile;

        $certificates = Certificate::where('user_id', $user->id)->get();
        $projects = Project::where('user_id', $user->id)->get();
        $experiences = Experience::where('user_id', $user->id)->latest()->get();
        $educations = Education::where('user_id', $user->id)->latest()->get();

        $pdf = Pdf::loadView('curriculo.pdf', compact('user', 'profile', 'certificates', 'projects', 'experiences', 'educations'))
                  ->setPaper('a4', 'portrait');

        return $pdf->download('curriculo-' . $user->name . '.pdf');
    }
}

