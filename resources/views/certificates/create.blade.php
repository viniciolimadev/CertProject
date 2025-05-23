@extends('layout')

@section('title', 'Novo Certificado')

@section('content')
    <h2>Adicionar Certificado</h2>

    <form method="POST" action="{{ route('certificates.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Título</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="file" class="form-label">Arquivo PDF</label>
            <input type="file" name="file_path" id="file_path" class="form-control" accept="application/pdf" required>
        </div>
        <div class="mb-3">
            <label for="description">Descrição</label>
            <textarea class="form-control" name="description_certificate" id="description_certificate"></textarea>
        </div>
        <div class="mb-3">
            <label for="start_date">Data de Início</label>
            <input type="date" name="start_date" id="start_date" class="form-control">
        </div>

        <div class="mb-3">
            <label for="end_date">Data de Término</label>
            <input type="date" name="end_date" id="end_date" class="form-control">
        </div>
        <div class="mb-3">
            <label for="duration">Duração</label>
            <input type="text" name="duration" id="duration" class="form-control" placeholder="Ex: 6 meses">
        </div>


        <button class="btn btn-success">Salvar</button>
    </form>

    <script>
        // Pega os elementos do DOM
        const fileInput = document.getElementById('file_path');
        const titleInput = document.getElementById('title');

        fileInput.addEventListener('change', () => {
            const file = fileInput.files[0];
            if (file) {
                // Pega o nome do arquivo sem a extensão .pdf
                const filename = file.name.replace(/\.pdf$/i, '');
                // Só preenche o título se o campo estiver vazio
                if (!titleInput.value) {
                    titleInput.value = filename;
                }
            }
        });
    </script>
@endsection
