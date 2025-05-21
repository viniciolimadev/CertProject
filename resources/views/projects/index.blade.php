<!-- resources/views/projects/index.blade.php -->
@extends('layout')

@section('title', 'Projetos')

@section('content')
    <h2>Projetos</h2>

    <a href="{{ route('projects.create') }}" class="btn btn-primary mb-3">Novo Projeto</a>

    <ul class="list-group">
        @foreach ($projects as $project)
            <li class="list-group-item">
                <h5>{{ $project->name }}</h5>
                <p>{{ $project->description }}</p>
                <a href="{{ $project->url_project }}" target="_blank">Acesse o projeto</a>
            </li>
        @endforeach
    </ul>
@endsection
