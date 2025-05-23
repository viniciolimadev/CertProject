<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Experience;
use Illuminate\Support\Facades\Auth;

class ExperienceController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->withErrors('Você precisa estar logado para ver suas experiências.');
        }

        $experiences = Experience::where('user_id', $user->id)
            ->latest()
            ->get();

        return view('experiences.index', compact('experiences'));
    }

    public function create()
    {
        return view('experiences.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->withErrors('Você precisa estar logado para adicionar uma experiência.');
        }

        $request->validate([
            'position' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        Experience::create([
            'user_id'    => $user->id,
            'position'   => $request->position,
            'company'    => $request->company,
            'description'=> $request->description,
            'start_date' => $request->start_date,
            'end_date'   => $request->end_date,
        ]);

        return redirect()->route('experiences.index')->with('success', 'Experiência adicionada com sucesso!');
    }

    public function destroy(Experience $experience)
    {
        $user = Auth::user();

        if ($experience->user_id !== $user->id) {
            abort(403, 'Você não tem permissão para excluir esta experiência.');
        }

        $experience->delete();

        return redirect()->route('experiences.index')->with('success', 'Experiência removida com sucesso!');
    }
}
