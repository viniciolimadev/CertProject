<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certificate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->withErrors('Você precisa estar logado para ver seus certificados.');
        }


        $certificates = Certificate::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('certificates.index', compact('certificates'));
    }

    public function viewPdf(Certificate $certificate)
    {
        if ($certificate->user_id !== Auth::id()) {
            abort(403, 'Você não tem permissão para acessar este certificado.');
        }

        $path = storage_path("app/public/{$certificate->file_path}");

        if (!file_exists($path)) {
            abort(404, 'Arquivo não encontrado.');
        }

        return response()->file($path);
    }

    public function create()
    {
        return view('certificates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'file_path' => 'required|mimes:pdf|max:2048',
            'description_certificate' => 'nullable|string'
        ]);

        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->withErrors('Você precisa estar logado para enviar um certificado.');
        }

        $path = $request->file('file_path')->store('certificates', 'public');

        Certificate::create([
            'title' => $request->title,
            'description_certificate' => $request->description_certificate,
            'file_path' => $path,
            'user_id' => $user->id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'duration' => $request->duration,
        ]);


        return redirect()->route('certificates.index')->with('success', 'Certificado salvo com sucesso!');
    }

    public function show(Certificate $certificate)
    {
        if ($certificate->user_id !== Auth::id()) {
            abort(403);
        }

        return view('certificates.show', compact('certificate'));
    }

    public function download(Certificate $certificate)
    {
        if ($certificate->user_id !== Auth::id()) {
            abort(403);
        }

        return response()->download(storage_path("app/public/{$certificate->file_path}"));
    }
    public function destroy(Certificate $certificate)
    {
        $this->authorize('delete', $certificate); // essa linha checa a policy
        $certificate->delete();

        return redirect()->route('certificates.index')->with('success', 'Certificado deletado com sucesso!');
    }



    // Método para fixar/desfixar certificados
    // public function togglePin(Certificate $certificate)
    // {
    //     $user = Auth::user();

    //     if ($certificate->user_id !== $user->id) {
    //         abort(403);
    //     }

    //     $certificate->pinned = !$certificate->pinned;
    //     $certificate->save();

    //     return redirect()->back()->with('success', 'Status de fixação do certificado atualizado!');
    // }
    // App\Http\Controllers\CertificateController.php

    // public function pin(Certificate $certificate)
    // {
    //     if ($certificate->user_id !== Auth::id()) {
    //         abort(403);
    //     }

    //     $certificate->update(['pinned' => true]);

    //     return redirect()->route('certificates.index')->with('success', 'Certificado fixado com sucesso!');
    // }

    // public function unpin(Certificate $certificate)
    // {
    //     if ($certificate->user_id !== Auth::id()) {
    //         abort(403);
    //     }

    //     $certificate->update(['pinned' => false]);

    //     return redirect()->route('certificates.index')->with('success', 'Certificado desfixado com sucesso!');
    // }
}
