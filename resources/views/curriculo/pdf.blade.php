<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Currículo de {{ $user->name }}</title>
    <style>
        @page {
            margin: 15mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
            color: #000;
        }

        .container {
            width: 100%;
            box-sizing: border-box;
        }

        h1 {
            text-align: center;
            font-size: 18pt;
            margin-bottom: 15px;
        }

        .section-title {
            font-size: 14pt;
            font-weight: bold;
            margin-top: 15px;
            margin-bottom: 5px;
            border-bottom: 1px solid #000;
            padding-bottom: 3px;
        }

        .section-content p {
            margin: 3px 0;
            line-height: 1.3;
        }

        .photo {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 4px;
            display: block;
            margin: 0 auto 10px auto;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Currículo de {{ $user->name }}</h1>

        {{-- Foto --}}
        @if(!empty($profile->photo_path))
            <img src="{{ public_path('storage/' . $profile->photo_path) }}" alt="Foto de {{ $user->name }}" class="photo">
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
                        {{ trim($link) }}@if(!$loop->last), @endif
                    @endforeach
                </p>
            @endif
        </div>

        {{-- FORMAÇÃO --}}
        <div class="section-title">Formações</div>
        <div class="section-content">
            @forelse($educations as $education)
                <p>
                    <strong>{{ $education->degree }}</strong> — {{ $education->institution }}<br>
                    {{ $education->start_date ? \Carbon\Carbon::parse($education->start_date)->format('m/Y') : 'Início indefinido' }}
                    - {{ $education->end_date ? \Carbon\Carbon::parse($education->end_date)->format('m/Y') : 'Atual' }}
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
                        {{ $project->url_project }}
                    @endif
                </p>
            @empty
                <p>Sem projetos.</p>
            @endforelse
        </div>
    </div>
</body>
</html>
