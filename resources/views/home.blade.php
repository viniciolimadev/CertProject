@extends('layout')

@section('title', 'Home')

@section('content')

    <style>
        /* Cards certificados menores */
        .card-certificate {
            height: 320px;
            /* altura menor */
            max-width: 100%;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        /* Embed PDF dentro do card certificado */
        .card-certificate embed {
            flex-shrink: 0;
            height: 160px;
            /* menor altura para embed */
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

    <hr>

    <h2>Informações Pessoais</h2>

    <div class="card mb-4 shadow-sm p-3">
        <div class="row align-items-center">
            {{-- Foto do usuário --}}
            @if (!empty($profile->photo_path))
                <div class="col-md-3 text-center mb-3 mb-md-0">
                    <img src="{{ asset('storage/' . $profile->photo_path) }}" alt="Foto de {{ auth()->user()->name }}"
                        class="img-fluid shadow rounded" style="width: 105px; height: 140px; object-fit: cover;">

                </div>
            @endif

            {{-- Informações pessoais --}}
            <div class="col-md-9">
                <ul class="list-unstyled">
                    <li><strong>Nome:</strong> {{ auth()->user()->name }}</li>
                    <li><strong>Telefone:</strong> {{ $profile->phone ?? 'Não informado' }}</li>
                    <li><strong>Cidade:</strong> {{ $profile->city ?? 'Não informado' }}</li>
                    <li><strong>Estado:</strong> {{ $profile->state ?? 'Não informado' }}</li>
                    <li><strong>E-mail:</strong> {{ auth()->user()->email }}</li>
                    <li>
                        <strong>Redes Sociais:</strong>
                        @if (!empty($profile->social_links) && is_array($profile->social_links))
                            <ul class="mb-0">
                                @foreach ($profile->social_links as $link)
                                    <li><a href="{{ $link }}" target="_blank">{{ $link }}</a></li>
                                @endforeach
                            </ul>
                        @else
                            Não informado
                        @endif
                    </li>
                </ul>
            </div>
        </div>
    </div>


    <hr>

    <h2>Formações Acadêmicas</h2>
    @if ($educations->isEmpty())
        <p>Sem formações cadastradas.</p>
    @else
        <div class="row">
            @foreach ($educations as $edu)
                <div class="col-md-6 mb-4">
                    <div class="card card-project shadow h-100">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $edu->degree }}</h5>
                            <p class="card-text">{{ $edu->institution }}</p>
                            <small class="text-muted">
                                {{ \Carbon\Carbon::parse($edu->start_date)->format('m/Y') }}
                                —
                                {{ $edu->end_date ? \Carbon\Carbon::parse($edu->end_date)->format('m/Y') : 'Atual' }}
                            </small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    <hr>


    <h2>Certificados</h2>
    @if ($certificates->isEmpty())
        <p>Sem certificados.</p>
    @else
        <div class="row">
            @foreach ($certificates as $certificate)
                <div class="col-md-6 mb-4">
                    <div class="card card-certificate shadow h-100">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $certificate->title }}</h5>

                            <p class="card-text text-truncate-3 flex-grow-1">{{ $certificate->description_certificate }}
                            </p>

                            <embed src="{{ asset('storage/' . $certificate->file_path) }}" width="100%"
                                type="application/pdf" class="mb-2">

                            <a href="{{ asset('storage/' . $certificate->file_path) }}" target="_blank"
                                class="btn btn-outline-primary btn-sm btn-bottom">Abrir em nova aba</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <hr>

    <h2>Experiências</h2>
    @if ($experiences->isEmpty())
        <p>Sem experiências profissionais cadastradas.</p>
    @else
        <div class="row">
            @foreach ($experiences as $experience)
                <div class="col-md-6 mb-4">
                    <div class="card shadow h-100 d-flex flex-column">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $experience->position }} —
                                <strong>{{ $experience->company }}</strong>
                            </h5>

                            @if ($experience->description)
                                <p class="card-text text-truncate-3 flex-grow-1">{{ $experience->description }}</p>
                            @endif

                            <small class="text-muted mt-auto">
                                {{ \Carbon\Carbon::parse($experience->start_date)->format('m/Y') }}
                                —
                                {{ $experience->end_date ? \Carbon\Carbon::parse($experience->end_date)->format('m/Y') : 'Atual' }}
                            </small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif


    <hr>

    <h2>Projetos</h2>
    @if ($projects->isEmpty())
        <p>Sem projetos.</p>
    @else
        <div class="row">
            @foreach ($projects as $project)
                <div class="col-md-6 mb-4">
                    <div class="card card-project shadow h-100">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $project->name }}</h5>

                            @if ($project->description)
                                <p class="card-text text-truncate-3 flex-grow-1">{{ $project->description }}</p>
                            @endif

                            @if ($project->url_project)
                                <a href="{{ $project->url_project }}" target="_blank"
                                    class="btn btn-outline-primary btn-sm btn-bottom">Abrir projeto</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
