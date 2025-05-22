@extends('layout')

@section('title', 'Home')

@section('content')

<style>
    /* Cards certificados menores */
    .card-certificate {
        height: 320px; /* altura menor */
        max-width: 100%;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }
    /* Embed PDF dentro do card certificado */
    .card-certificate embed {
        flex-shrink: 0;
        height: 160px; /* menor altura para embed */
    }
    /* Cards projetos tamanho fixo */
    .card-project {
        height: 350px;
        max-width: 100%;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    /* Texto com corte após 3 linhas para não quebrar layout */
    .text-truncate-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;  
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Para botões alinharem no rodapé */
    .btn-bottom {
        margin-top: auto;
    }
</style>

<h1>Bem-vindo, {{ auth()->user()->name }}!</h1>

<h2>Certificados</h2>
@if($certificates->isEmpty())
    <p>Sem certificados.</p>
@else
    <div class="row">
        @foreach($certificates as $certificate)
            <div class="col-md-6 mb-4">
                <div class="card card-certificate shadow h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $certificate->title }}</h5>

                        <p class="card-text text-truncate-3 flex-grow-1">{{ $certificate->description_certificate }}</p>

                        <embed src="{{ asset('storage/' . $certificate->file_path) }}" width="100%" type="application/pdf" class="mb-2">

                        <a href="{{ asset('storage/' . $certificate->file_path) }}" target="_blank" class="btn btn-outline-primary btn-sm btn-bottom">Abrir em nova aba</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

<hr>

<h2>Projetos</h2>
@if($projects->isEmpty())
    <p>Sem projetos.</p>
@else
    <div class="row">
        @foreach($projects as $project)
            <div class="col-md-6 mb-4">
                <div class="card card-project shadow h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $project->name }}</h5>

                        @if ($project->description)
                            <p class="card-text text-truncate-3 flex-grow-1">{{ $project->description }}</p>
                        @endif

                        @if ($project->url_project)
                            <a href="{{ $project->url_project }}" target="_blank" class="btn btn-outline-primary btn-sm btn-bottom">Abrir projeto</a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

@endsection
