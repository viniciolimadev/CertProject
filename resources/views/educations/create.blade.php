@extends('layout')

@section('title', 'Nova Formação')

@section('content')
    <h1>Adicionar Formação</h1>

    <form method="POST" action="{{ route('educations.store') }}">
        @csrf

        <div class="mb-3">
            <label for="degree" class="form-label">Graduação</label>
            <input type="text" name="degree" id="degree" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="institution" class="form-label">Instituição</label>
            <input type="text" name="institution" id="institution" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="start_date" class="form-label">Data de Início</label>
            <input type="date" name="start_date" id="start_date" class="form-control">
        </div>

        <div class="mb-3">
            <label for="end_date" class="form-label">Data de Conclusão / Previsão</label>
            <input type="date" name="end_date" id="end_date" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
@endsection
