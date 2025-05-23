@extends('layout')

@section('title', 'Formações')

@section('content')
    <h1>Formações Acadêmicas</h1>

    <a href="{{ route('educations.create') }}" class="btn btn-primary mb-3">Nova Formação</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @forelse ($educations as $education)
        <div class="card mb-3 p-3">
            <h5>{{ $education->degree }} - {{ $education->institution }}</h5>
            <p>
                {{ $education->start_date ? date('d/m/Y', strtotime($education->start_date)) : 'Início indefinido' }}
                —
                {{ $education->end_date ? date('d/m/Y', strtotime($education->end_date)) : 'Conclusão prevista' }}
            </p>
            <form method="POST" action="{{ route('educations.destroy', $education) }}" onsubmit="return confirm('Deseja deletar?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm">Deletar</button>
            </form>
        </div>
    @empty
        <p>Sem formações cadastradas.</p>
    @endforelse
@endsection
