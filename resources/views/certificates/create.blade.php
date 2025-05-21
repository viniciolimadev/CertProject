<!-- resources/views/certificates/create.blade.php -->
@extends('layout')

@section('title', 'Novo Certificado')

@section('content')
    <h2>Adicionar Certificado</h2>

    <form method="POST" action="{{ route('certificates.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Título</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="file" class="form-label">Arquivo PDF</label>
            <input type="file" name="file" class="form-control" accept="application/pdf" required>
        </div>
        <div class="mb-3">
        <label for="description">Descrição</label>
        <textarea class="form-control" name="description_certificate" id="description_certificate"></textarea>
        </div>

        <button class="btn btn-success">Salvar</button>
    </form>
@endsection
