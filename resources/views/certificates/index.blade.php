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
                                <h5 class="card-title">
                                    {{ $certificate->title }}
                                </h5>

                                <p class="card-text text-truncate-3 flex-grow-1">
                                    {{ $certificate->description_certificate }}
                                </p>

                                <embed src="{{ asset('storage/' . $certificate->file_path) }}" width="100%" height="200px" type="application/pdf" class="mb-2">

                                <div class="mt-auto">
                                    <a href="{{ asset('storage/' . $certificate->file_path) }}" target="_blank" class="btn btn-outline-primary btn-sm">Abrir em nova aba</a>
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
