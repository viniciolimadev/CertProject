@extends('layout')

@section('title', 'Meu Currículo')

@section('content')
<style>
    .a4-page {
        width: 210mm;
        min-height: 297mm;
        padding: 20mm;
        margin: auto;
        background: white;
        box-shadow: 0 0 5px rgba(0,0,0,0.1);
        font-family: Arial, sans-serif;
        font-size: 14px;
    }

    .section-title {
        font-size: 18px;
        font-weight: bold;
        margin-top: 20px;
        border-bottom: 2px solid #333;
        padding-bottom: 4px;
    }

    .section-content p {
        margin: 4px 0;
    }

    a {
        color: #007bff;
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }
    .photo {
    width: 120px;
    height: 120px;
    object-fit: cover;
    border-radius: 8px;
    display: block;
    margin: 0 auto 20px auto;
    box-shadow: 0 0 4px rgba(0,0,0,0.2);
    }
    .download-btn {
        display: inline-block;
        font-size: 18px;
        font-weight: bold;
        padding: 12px 32px;
        border: 2px solid #28a745;
        border-radius: 8px;
        margin: 40px auto 60px auto;
        color: white;
        background-color: #28a745;
        text-decoration: none;
        transition: 0.3s;
    }

    .download-btn:hover {
        background-color: #218838;
        border-color: #1e7e34;
        text-decoration: none;
        color: white;
    }

    .download-container {
        text-align: center;
    }
}

</style>
<div class="a4-page">
    <h1 style="text-align: center;">Currículo de {{ $user->name }}</h1>

    {{-- Foto do usuário --}}
    @if(!empty($profile->photo_path))
    <img src="{{ asset('storage/' . $profile->photo_path) }}" alt="Foto de {{ $user->name }}" class="photo">
    @endif


    {{-- DADOS PESSOAIS --}}
    <div class="section-title">Dados Pessoais</div>
    <div class="section-content">
        <p><strong>Nome completo:</strong> {{ $user->name }}</p>
        <p><strong>Endereço:</strong> {{ $profile->city ?? 'Cidade não informada' }}, {{ $profile->state ?? 'Estado não informado' }}</p>
        <p><strong>Telefone:</strong> {{ $profile->phone ?? 'Não informado' }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>

        @if(!empty($profile->social_links))
            <p><strong>Redes Sociais:</strong>
                @php
                    $links = is_array($profile->social_links) ? $profile->social_links : explode(',', $profile->social_links);
                @endphp
                @foreach($links as $link)
                    <a href="{{ trim($link) }}" target="_blank">{{ trim($link) }}</a>@if(!$loop->last), @endif
                @endforeach
            </p>
        @endif
    </div>

    {{-- FORMAÇÃO --}}
    <div class="section-title">Formações</div>
    <div class="section-content">
        @forelse($educations as $education)
            <p>
                <strong>{{ $education->degree }}</strong> — {{ $education->institution }}
                ({{ $education->start_date ? \Carbon\Carbon::parse($education->start_date)->format('m/Y') : 'Início indefinido' }}
                - {{ $education->end_date ? \Carbon\Carbon::parse($education->end_date)->format('m/Y') : 'Atual' }})
            </p>
        @empty
            <p>Sem formações registradas.</p>
        @endforelse
    </div>

    {{-- EXPERIÊNCIAS --}}
    <div class="section-title">Experiências</div>
    <div class="section-content">
        @forelse($experiences as $experience)
            <p>
                <strong>{{ $experience->position }}</strong> em {{ $experience->company }}<br>
                {{ $experience->start_date ? \Carbon\Carbon::parse($experience->start_date)->format('m/Y') : 'Início indefinido' }}
                - {{ $experience->end_date ? \Carbon\Carbon::parse($experience->end_date)->format('m/Y') : 'Atual' }}<br>
                {{ $experience->description }}
            </p>
        @empty
            <p>Sem experiências registradas.</p>
        @endforelse
    </div>

    {{-- CERTIFICADOS --}}
    <div class="section-title">Certificados</div>
    <div class="section-content">
        @forelse($certificates as $certificate)
            <p>
                <strong>{{ $certificate->title }}</strong><br>
                {{ $certificate->description_certificate }}
            </p>
        @empty
            <p>Sem certificados.</p>
        @endforelse
    </div>

    {{-- PROJETOS --}}
    <div class="section-title">Projetos</div>
    <div class="section-content">
        @forelse($projects as $project)
            <p>
                <strong>{{ $project->name }}</strong><br>
                {{ $project->description }}<br>
                @if($project->url_project)
                    <a href="{{ $project->url_project }}" target="_blank">{{ $project->url_project }}</a>
                @endif
            </p>
            
        @empty
            <p>Sem projetos.</p>
        @endforelse
    </div>
</div>
<div class="download-container">
    <a href="{{ route('curriculo.export') }}" class="download-btn" target="_blank">
        📄 Baixar Currículo em PDF
    </a>
</div>


@endsection
