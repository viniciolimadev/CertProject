@extends('layout')

@section('title', 'Certificados')

@section('content')
    <div class="container">
        <h1 class="mb-4">Certificados</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('certificates.create') }}" class="btn btn-primary mb-4">Novo Certificado</a>

        <div class="row">
            @forelse ($certificates as $certificate)
                @php
                    $isOwner = $certificate->user_id === auth()->id();
                @endphp

                @if ($isOwner)
                    <div class="col-md-6 mb-4">
    <div class="card shadow h-100 d-flex flex-column">
        <div class="card-body d-flex flex-column">
            <h5 class="card-title">{{ $certificate->title }}</h5>

            <p class="card-text text-truncate-3 flex-grow-1">
                {{ $certificate->description_certificate }}
            </p>

            <embed src="{{ asset('storage/' . $certificate->file_path) }}" width="100%" height="200px" type="application/pdf" class="mb-2">

            <div class="mt-auto d-flex gap-2">
                <a href="{{ asset('storage/' . $certificate->file_path) }}" target="_blank" class="btn btn-primary btn-sm">
                    Abrir em nova aba
                </a>

                <form action="{{ route('certificates.destroy', $certificate->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja deletar este certificado?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Deletar</button>
                </form>

                <button class="btn btn-secondary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#moreInfo{{ $certificate->id }}">
                    Mais informações
                </button>
            </div>

            <div class="collapse mt-3" id="moreInfo{{ $certificate->id }}">
                <ul class="list-group list-group-flush">
                    @if ($certificate->start_date)
                        <li class="list-group-item"><strong>Início:</strong> {{ \Carbon\Carbon::parse($certificate->start_date)->format('d/m/Y') }}</li>
                    @endif
                    @if ($certificate->end_date)
                        <li class="list-group-item"><strong>Término:</strong> {{ \Carbon\Carbon::parse($certificate->end_date)->format('d/m/Y') }}</li>
                    @endif
                    @if ($certificate->duration)
                        <li class="list-group-item"><strong>Duração:</strong> {{ $certificate->duration }}</li>
                    @endif
                    <li class="list-group-item"><strong>Descrição completa:</strong> {{ $certificate->description_certificate }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>

                @endif
            @empty
                <p>Nenhum certificado cadastrado.</p>
            @endforelse
        </div>
    </div>
@endsection
