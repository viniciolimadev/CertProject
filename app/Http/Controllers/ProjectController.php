<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index()
{
    $projects = Project::all();

    return view('projects.index', compact('projects')); // ✅ Isso passa $projects para a view
}

    public function create()
    {
        return view('projects.create');
    }

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'url_project' => 'nullable|url',
    ]);

    $project = Project::create([
        'name' => $request->name,
        'description' => $request->description,
        'url_project' => $request->url_project
    ]);

    return redirect()->route('projects.index')->with('success', 'Projeto salvo com sucesso!');
}



}