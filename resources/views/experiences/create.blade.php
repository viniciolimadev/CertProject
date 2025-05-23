@extends('layout')

@section('title', 'Nova Experiência')

@section('content')
<div class="container">
    <h1>Nova Experiência</h1>

    <form action="{{ route('experiences.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="position">Cargo</label>
            <input type="text" name="position" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="company">Empresa</label>
            <input type="text" name="company" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="description">Descrição / Funções</label>
            <textarea name="description" class="form-control" rows="4"></textarea>
        </div>

        <div class="form-group">
            <label for="start_date">Data de Início</label>
            <input type="date" name="start_date" class="form-control">
        </div>

        <div class="form-group">
            <label for="end_date">Data de Término</label>
            <input type="date" name="end_date" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Salvar</button>
    </form>
</div>
@endsection
