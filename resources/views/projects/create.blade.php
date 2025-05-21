<!-- resources/views/projects/create.blade.php -->
@extends('layout')

@section('title', 'Novo Projeto')

@section('content')
    <h2>Adicionar Projeto</h2>

    <form method="POST" action="{{ route('projects.store') }}">
    @csrf

    <div class="mb-3">
        <label for="name">Nome do Projeto</label>
        <input type="text" class="form-control" name="name" id="name" required>
    </div>

    <div class="mb-3">
        <label for="description">Descrição</label>
        <textarea class="form-control" name="description" id="description"></textarea>
    </div>

    <div class="mb-3">
        <label for="url_project">URL do projeto</label>
        <input type="url" class="form-control" name="url_project" id="url_project">
    </div>

    <button type="submit" class="btn btn-primary">Salvar Projeto</button>
</form>

@endsection
