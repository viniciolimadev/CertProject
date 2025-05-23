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

                <div class="d-flex gap-2">
                    <a href="{{ $project->url_project }}" target="_blank" class="btn btn-primary">
                        Acesse o projeto
                    </a>

                    <form action="{{ route('projects.destroy', $project->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja deletar este projeto?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            Deletar
                        </button>
                    </form>
                </div>
            </li>
        @endforeach
    </ul>
@endsection
